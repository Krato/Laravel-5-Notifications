<?php

namespace Infinety\Notifications\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use Infinety\Notifications\Models\GroupNotification;
use Infinety\Notifications\Models\Notification;
use Infinety\Notifications\Requests\NotificationRequest;

class NotificationsController extends BaseController
{

	/**
     * Model used on config file
     *
     * @var \Illuminate\Foundation\Application|mixed
     */
	protected $model;


	/**
     * Model column used on config file
     *
     * @var string
     */
    protected $modelColumn;


    /**
     * Types of notification.
     *
     * @var array
     */
    protected $types;


	public function __construct()
	{
		$this->model = app(config('notifications.model'));
		$this->modelColumn = config('notifications.model_field');
		$this->types = collect(config('notifications.notification_types'));
	}

	/**
	 * Index of notifications
	 *
	 * @return view
	 */
	public function index(){
		 return $this->firstViewThatExists('vendor/infinety/notifications/index', 'notifications::index');
	}

	/**
	 * Return json of all notifications aggrouped by count
	 *
	 * @return json
	 */
	public function getNotifications()
	{
		$notifications = Notification::groupBy('count');
		return Datatables::of($notifications)
			->editColumn('id', function($notification){
				return $notification->count;
			})
			->editColumn('type', function($notification){
				if($this->types->has($notification->type)){
					return '<span class="label '.$this->types->get($notification->type).'">'.$notification->type.'</span>';
				} else {
					return $notification->type;
				}
			})
			->addColumn('actions', function ($notification) {
                $html = '<a href="'. url('notifications/view/'.$notification->count).'" class="btn btn-sm btn-primary" style="margin-right:5px"><i class="fa fa-eye"></i> View</a>'.
                		'<a href="'. url('notifications/destroy/'.$notification->count).'" data-button="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>';
        		return $html;
            })
			->make(true);
	}

	/**
	 * Get all notifications from count
	 *
	 * @param  integer $idCount
	 * @return view
	 */
	public function getview($idCount)
	{
		$notification = Notification::where('count', $idCount)->first();
		if(!$notification){
			return redirect()->back();
		}
		return $this->firstViewThatExists('vendor/infinety/notifications/view', 'notifications::view', ['notification' => $notification]);
	}

	/**
	 * Return json of all notifications from count
	 *
	 * @param  integer $idCount
	 * @return json
	 */
	public function getNotificationsView($idCount)
	{
		$notifications = Notification::where('count', $idCount);
		return Datatables::of($notifications)
			->addColumn('model', function($notification){
				if($notification->model){
					return $notification->model->{config('notifications.model_column')};
				} else {
					return null;
				}
			})
			->editColumn('type', function($notification){
				if($this->types->has($notification->type)){
					return '<span class="label '.$this->types->get($notification->type).'">'.$notification->type.'</span>';
				} else {
					return $notification->type;
				}
			})
			->editColumn('is_read', function($notification){
				return ($notification->is_read) ? '<span class="label label-success">Yes</span>' : '<span class="label label-default">No</span>';
			})
			->addColumn('actions', function ($notification) {
                return '<a href="'. url('notifications/view/destroy/'.$notification->id).'" data-button="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>';
            })
			->make(true);
	}


	public function create()
	{
		$lists = $this->model->lists(config('notifications.model_field'), config('notifications.model_column'))->flip();
        $lists->prepend('all', 'all');
		return $this->firstViewThatExists('vendor/infinety/notifications/create', 'notifications::create', ['modelList' => $lists]);
	}


	/**
	 * Stores a new Notification
	 *
	 * @param  NotificationRequest $request
	 * @return redirect
	 */
	public function store(NotificationRequest $request)
	{
		if ($request->get('model') == 'all') {
            $toModify = $this->model->all();
        } else {
            $toModify = $this->model->find($request->get('model'));
        }
        if ($toModify == null) {
            return redirect()->back()->withErrors(['model'=> 'Sorry but, model not exists' ]);
        }
        if ($request->get('model') == 'all') {
            foreach ($toModify as $modelValue) {
                $this->createNotification( $modelValue->{$this->modelColumn}, $request );
            }
        } else {
            $this->createNotification( $request->get('model'), $request );
        }
        return redirect()->to('notifications');
	}



	public function destroy($idCount)
	{
		Notification::where('count', $idCount)->delete();
		return json_encode(true);
	}


	public function destroySingle($id)
	{
		Notification::find($id)->delete();
		return json_encode(true);
	}

    
    /**
     * Create a notification based of given id and request
     *
     * @param  integer $id
     * @param  Request $request
     */
    private function createNotification($id, $request)
    {
		$count = Notification::max('count');

        $notification = Notification::create([
                'model_id'  => $id,
				'count'		=> intval($count) + 1,
                'type'      => $request->get('ntype'),
                'subject'   => $request->get('subject'),
                'message'   => $request->get('message'),
                'sent_at'   => Carbon::now()
            ]);
    }


	/**
     *
     * Allow replace the default views by placing a view with the same name.
     * If no such view exists, load the one from the package.
     *
     * @param $first_view
     * @param $second_view
     * @param array $information
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function firstViewThatExists($first_view, $second_view, $information = [])
    {
        // load the first view if it exists, otherwise load the second one
        if (view()->exists($first_view))
        {
            return view($first_view, $information);
        }
        else
        {
            return view($second_view, $information);
        }
    }

}