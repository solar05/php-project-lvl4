<?php

namespace Task_Manager;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function createdTasks()
    {
        return $this->hasMany('Task_Manager\Task', 'creator_id');
    }

    public function assignedTasks()
    {
        return $this->hasMany('Task_Manager\Task', 'assigned_to_id');
    }

    public function canUpdate()
    {
        return $this->id == Auth::id();
    }

    public function isTaskCreator(User $user)
    {
        return $user['id'] == $this->id;
    }
}
