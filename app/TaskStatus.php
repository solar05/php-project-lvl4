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
        return TaskStatus::where('name', 'created')->first();
    }

    public static function getInWorkState()
    {
        return TaskStatus::where('name', 'in_work')->first();
    }

    public static function getTestingState()
    {
        return TaskStatus::where('name', 'testing')->first();
    }

    public static function getCompletedState()
    {
        return TaskStatus::where('name', 'completed')->first();
    }

    public static function proceedToNextState($state)
    {
        if (!static::isSystemStatus($state)) {
            throw new \Exception('Proceeding of non system statuses is prohibited');
        }
        $statusMap = [
            'created' => function () {
                return TaskStatus::getInWorkState();
            },
            'in_work' => function () {
                return TaskStatus::getTestingState();
            },
            'testing' => function () {
                return TaskStatus::getCompletedState();
            },
            'completed' => function () {
                return TaskStatus::getCompletedState();
            }
        ];
        return $statusMap[$state]();
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
