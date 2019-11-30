<?php

namespace Task_Manager;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    const STATUS_CREATED = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_TESTING = 3;
    const STATUS_COMPLETED = 4;

    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany('Task_Manager\Task', 'status_id');
    }

    public static function getCreatedState()
    {
        return TaskStatus::find(TaskStatus::STATUS_CREATED);
    }

    public static function isSystemStatus($state)
    {
        return in_array($state, [
            'created',
            'in_work',
            'testing',
            'completed'
        ]);
    }
}
