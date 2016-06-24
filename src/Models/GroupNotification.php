<?php

namespace Infinety\Notifications\Models;

// use Illuminate\Database\Eloquent\Model;
use App\SystemModel as Model;

class GroupNotification extends Model
{

	public function model()
	{
		return $this->belongsToMany(config('notifications.model'), 'group_notifications_model', 'group_notifications_id', 'model_id');
	}

}