<?php

namespace Task_Manager\Policies;

use Task_Manager\User;
use Task_Manager\TaskStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any task statuses.
     *
     * @param  \Task_Manager\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the task status.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\TaskStatus  $taskStatus
     * @return mixed
     */
    public function view(User $user, TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Determine whether the user can create task statuses.
     *
     * @param  \Task_Manager\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the task status.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\TaskStatus  $taskStatus
     * @return mixed
     */
    public function update(User $user, TaskStatus $taskStatus)
    {
        return !TaskStatus::isSystemStatus($taskStatus['name']);
    }

    /**
     * Determine whether the user can delete the task status.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\TaskStatus  $taskStatus
     * @return mixed
     */
    public function delete(User $user, TaskStatus $taskStatus)
    {
        return !TaskStatus::isSystemStatus($taskStatus['name']);
    }

    /**
     * Determine whether the user can restore the task status.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\TaskStatus  $taskStatus
     * @return mixed
     */
    public function restore(User $user, TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the task status.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\TaskStatus  $taskStatus
     * @return mixed
     */
    public function forceDelete(User $user, TaskStatus $taskStatus)
    {
        //
    }
}
