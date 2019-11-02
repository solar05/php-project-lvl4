<?php

namespace Task_Manager;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function creator()
    {
        return $this->belongsTo('Task_Manager\User');
    }

    public function assignedTo()
    {
        return $this->belongsTo('Task_Manager\User');
    }

    public function status()
    {
        return $this->belongsTo('Task_Manager\TaskStatus');
    }

    public function tags()
    {
        return $this->belongsToMany('Task_Manager\Tag', 'tag_task');
    }

    public static function getCompletedUserTasksCount($userId)
    {
        return  $userTasks = Task::where('assigned_to_id', $userId)
            ->whereIn('status_id', [4])
            ->count();
    }
}
