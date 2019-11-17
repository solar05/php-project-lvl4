<?php

namespace Task_Manager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

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
        return Task::with(['assignedTo'])
            ->assignedToUser(Auth::id())
            ->withStatus(TaskStatus::STATUS_COMPLETED)
            ->count();
    }

    public function scopeCreatedByUser($query, $userId)
    {
        if (empty($userId)) {
            return $query;
        }
        return $query->where('creator_id', Auth::id());
    }

    public function scopeWithStatus($query, $statusId)
    {
        if (empty($statusId)) {
            return $query;
        }
        return $query->where('status_id', $statusId);
    }

    public function scopeAssignedToUser($query, $userId)
    {
        if (empty($userId)) {
            return $query;
        }
        return $query->where('assigned_to_id', $userId);
    }

    public function scopeWithTag($query, $tagId)
    {
        if (empty($tagId)) {
            return $query;
        }
        return $query->whereHas('tags', function ($query) use ($tagId) {
            $query->where('tag_id', $tagId);
        });
    }

    public static function getPaginatedAndFilteredTasks()
    {
        return Task::with(['tags', 'creator', 'assignedTo'])
            ->createdByUser(Input::get('is_my_task'))
            ->withStatus(Input::get('status_id'))
            ->assignedToUser(Input::get('assigned_to_id'))
            ->withTag(Input::get('tag_id'))
            ->paginate(15);
    }
}
