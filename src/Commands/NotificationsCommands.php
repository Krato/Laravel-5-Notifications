<?php

namespace Infinety\Notifications\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Infinety\Notifications\Models\Notification;

class NotificationsCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:new
    						{--notify= : A model ID, or all}
    						{--subject= : Notification subject}
    						{--message= : Notification message}
    						{--type= : Type of notifications defined in config file}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send new notification';


    /**
     * Model used on config file.
     *
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $model;

    /**
     * Model column used on config file.
     *
     * @var string
     */
    protected $modelColumn;

    /**
     * Model ID or all.
     *
     * @var int|string
     */
    protected $notify;


    /**
     * Subject for the notification.
     *
     * @var string
     */
    protected $subject;

    /**
     * Message for the notification.
     *
     * @var string
     */
    protected $message;

    /**
     * Type of notification. Default to: info.
     *
     * @var string
     */
    protected $type;


    /**
     * Types of notification.
     *
     * @var array
     */
    protected $types;


    /**
     * An array with all notified models.
     *
     * @var array
     */
    protected $notified;

    public function __construct()
    {
        $this->type = 'info';
        $this->model = app(config('notifications.model'));
        $this->modelColumn = config('notifications.model_field');
        $this->types = collect(config('notifications.notification_types'));
        $this->notified = collect();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->welcome();

        $this->checkOptions();

        $this->preview();

        if ($this->confirm('Do you want to send this notification?')) {
            $this->notifyProcess();
            $this->printResult();
        }


        // dump($this->notify);
        // dump($this->type);
    }

    /**
     * Welcome Message.
     */
    private function welcome()
    {
        $this->comment('');
        $this->comment('|');
        $this->comment('| Welcome to  Notification System.');
        $this->comment("| You're going to send a notification message.");
        $this->comment('|');
        $this->comment('');
    }

    /*
     * Check and define all Options
     */
    private function checkOptions()
    {
        //Check for Notify
        if ($this->option('notify') == null) {
            $lists = $this->model->get()->lists(config('notifications.model_field'));
            $lists->prepend('all');
            $this->notify = $this->anticipate('Model ID or all', $lists->all());
        } else {
            $this->notify = $this->option('notify');
        }


        //Check for subject
        if ($this->option('subject') == null) {
            $this->subject = $this->ask('Please, write the message Subject');
        } else {
            $this->subject = $this->option('subject');
        }

        //Check for subject
        if ($this->option('message') == null) {
            $this->message = $this->ask('Please, write the message');
        } else {
            $this->message = $this->option('message');
        }

        if ($this->option('type') == null) {
            $this->type = $this->choice('Please choose a notification type', $this->types->keys()->toArray());
        } else {
            if (in_array($this->option('type'), $this->types)) {
                $this->type = $this->option('type');
            } else {
                $this->type = $this->choice('Please choose a notification type', $this->types->keys()->toArray());
            }
        }
    }

    /**
     * Generates a preview for the info.
     */
    private function preview()
    {
        $headers = ['Information', 'User values'];

        $info = [
            ['Notify to',  $this->notify],
            ['Subject',    $this->subject],
            ['Message',    $this->message],
            ['Type',       $this->type],
        ];

        $this->table($headers, $info);
    }

    /**
     * Process and send the notification.
     */
    private function notifyProcess()
    {
        $toModify = null;

        if ($this->notify == 'all') {
            $toModify = $this->model->all();
        } else {
            $toModify = $this->model->find($this->notify);
        }
        if ($toModify == null) {
            $this->error(PHP_EOL.PHP_EOL.' Sorry, this model ID does not exists. Please check it.'.PHP_EOL);

            return;
        }
        if ($this->notify == 'all') {
            foreach ($toModify as $modelValue) {
                $this->createNotification($modelValue->{$this->modelColumn});
            }
        } else {
            $this->createNotification($this->notify);
        }
    }

    /**
     * Create a notification based of given id.
     *
     * @param int $id
     */
    private function createNotification($id)
    {
        $count = Notification::max('count');
        $notification = Notification::create([
                'model_id'  => $id,
                'count'     => intval($count) + 1,
                'type'      => $this->type,
                'subject'   => $this->subject,
                'message'   => $this->message,
                'sent_at'   => Carbon::now(),
            ]);

        $arrayToSave = [
            'model_id'  => $id,
            'result'    => 'error',
        ];

        if ($notification != null) {
            $arrayToSave['result'] = 'success';
        }

        $this->notified->push($arrayToSave);
    }

    private function printResult()
    {
        $headers = ['Model ID', 'Result'];

        $this->table($headers, $this->notified);
    }
}
