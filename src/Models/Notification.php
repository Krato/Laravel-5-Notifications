<?php 

namespace Infinety\Notifications\Models;

// use Illuminate\Database\Eloquent\Model;
use App\SystemModel as Model;

class Notification extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['model_id', 'count', 'type', 'subject', 'message', 'is_read', 'sent_at'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['sent_at', 'created_at', 'updated_at'];


    /**
     * Returns ID of notification
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Return type of notification
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Returns the subject of notification
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }


    /**
     * Returns message of notification
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Check if notification is read or not
     *
     * @return boolean
     */
    public function isRead()
    {
        return ($this->is_read) ? true : false;
    }

    public function model()
    {
        return $this->belongsTo(config('notifications.model'));
    }


    /**
     * Model Mutator to change integer to boleean
     *
     * @param  integer $value
     * @return boolean
     */
    public function getIsReadAttribute($value)
    {
        return ($value) ? true : false;
    }
}
