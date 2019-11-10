<?php

namespace Tests\Feature;

use Task_Manager\Task;
use Task_Manager\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;


class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $password;
    protected $userData;
    protected $taskData;
    protected $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->password = 'Very secret';
        $this->userData = [
            'name' => 'John Doe',
            'email' => 'example@mail.test',
            'password' => Hash::make($this->password)
        ];
        $this->user = factory(User::class)->create($this->userData);
        $this->seed();
        $this->taskData = [
            'name' => 'Test',
            'description' => 'Testing task',
            'tags' => 'TEsT taGS',
            'assignedTo' => $this->user['name']
        ];
        $this->task = factory(Task::class, 1)->create()->first();
    }

    public function testTaskIndex()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testTaskStore()
    {
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $this->taskData);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['name' => 'Test',
            'description' => 'Testing task']);
        $this->assertDatabaseHas('tags', ['name' => 'tags']);
        $this->assertDatabaseHas('tags', ['name' => 'test']);
    }

    public function testTaskShow()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.show', $this->task->id));
        $response->assertOk();
    }

    public function testTaskDestroy()
    {
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $this->task->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', [
            'name' => $this->task->name,
            'description' => $this->task->description
        ]);
    }

    public function testTaskUpdate()
    {
        $newUser = factory(User::class, 1)->create()->first();
        $newTaskData = [
            'name' => 'New',
            'description' => 'Changed name',
            'tags' => 'change',
            'assignedTo' => $newUser['name']
        ];
        $response = $this->actingAs($this->user)->patch(route('tasks.update', $this->task->id), $newTaskData);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $this->task->id,
            'name' => $newTaskData['name'],
            'description' => $newTaskData['description'],
            'assigned_to_id' => $newUser->id
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => $newTaskData['tags']
        ]);
    }
}
