<?php

namespace Task_Manager\Policies;

use Illuminate\Support\Facades\Auth;
use Task_Manager\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Task_Manager\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Task_Manager\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\User  $model
     * @return mixed
     */
    public function update(User $user, User $userToUpdate)
    {
        return $user == $userToUpdate;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\User  $model
     * @return mixed
     */
    public function delete(User $user, User $userToDelete)
    {
        return $user == $userToDelete;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Task_Manager\User  $user
     * @param  \Task_Manager\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
