<?php

namespace Task_Manager\Policies;

use Task_Manager\User;
use Task_Manager\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tasks.
     *
     * @param  \Task_Manager\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the task.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\Task  $task
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \Task_Manager\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $user == $task->creator()->first();
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return $user == $task->creator()->first();
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\Task  $task
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\Task  $task
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        //
    }
}
