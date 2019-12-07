<?php

namespace Task_Manager\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Task_Manager\Policies\TaskPolicy;
use Task_Manager\Policies\UserPolicy;
use Task_Manager\Task;
use Task_Manager\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'Task_Manager\Model' => 'Task Manager\Policies\ModelPolicy',
        Task::class => TaskPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register an        Gate::define('update.task', function ($user, $task) {
            return $user->id == $task->creatorId;
        });
y authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
