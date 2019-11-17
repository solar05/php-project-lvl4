<?php

namespace Tests\Feature;

use Task_Manager\Task;
use Task_Manager\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    protected $user;
    protected $taskData;
    protected $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->taskData = [
            'name' => 'Test',
            'description' => 'Testing task',
            'tags' => 'TEsT taGS',
            'assignedTo' => $this->user['name']
        ];
        $this->actingAs($this->user);
        $this->task = factory(Task::class)->create();
    }

    public function testTaskIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testTaskStore()
    {
        $response = $this->post(route('tasks.store'), $this->taskData);
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', ['name' => 'Test',
            'description' => 'Testing task']);
        $this->assertDatabaseHas('tags', ['name' => 'tags']);
        $this->assertDatabaseHas('tags', ['name' => 'test']);
    }

    public function testTaskShow()
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertOk();
    }

    public function testTaskDestroy()
    {
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', [
            'name' => $this->task->name,
            'description' => $this->task->description
        ]);
    }

    public function testTaskEdit()
    {
        $newUser = factory(User::class, 1)->create()->first();
        $newTaskData = [
            'name' => 'New',
            'description' => 'Changed name',
            'tags' => 'change',
            'assignedTo' => $newUser['name']
        ];
        $response = $this->patch(route('tasks.update', $this->task), $newTaskData);
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
