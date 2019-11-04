<?php

namespace Task_Manager;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
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
        if (!in_array($state, [1, 2, 3, 4])) {
            throw new \Exception('Proceeding of non system statuses is prohibited');
        }
        $statusMap = [
            '1' => function () {
                return TaskStatus::getInWorkState();
            },
            '2' => function () {
                return TaskStatus::getTestingState();
            },
            '3' => function () {
                return TaskStatus::getCompletedState();
            },
            '4' => function () {
                return TaskStatus::getCompletedState();
            }
        ];
        return $statusMap[$state]();
    }
}
