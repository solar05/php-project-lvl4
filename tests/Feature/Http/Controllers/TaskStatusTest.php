<?php

namespace Tests\Feature;

use Task_Manager\TaskStatus;
use Task_Manager\User;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    protected $user;
    protected $statusData;
    protected $status;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        $this->statusData = ['name' => 'Some status'];
        $this->status = factory(TaskStatus::class)->create();
    }

    public function testStatusIndex()
    {
        $response = $this->get(route('statuses.index'));
        $response->assertOk();
    }

    public function testStatusStore()
    {
        $response = $this->post(route('statuses.store'), $this->statusData);
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', ['name' => $this->statusData['name']]);
    }


    public function testStatusShow()
    {
        $response = $this->get(route('statuses.show', $this->status));
        $response->assertOk();
    }

    public function testStatusDestroy()
    {
        $response = $this->delete(route('statuses.destroy', $this->status));
        $response->assertRedirect();
        $this->assertDatabaseMissing('task_statuses', [
            'name' => $this->status->name
        ]);
    }

    public function testSystemStatusDestroy()
    {
        $response = $this->delete(route('statuses.destroy', TaskStatus::STATUS_CREATED));
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', [
            'name' => 'created'
        ]);
    }


    public function testStatusUpdate()
    {
        $newStatusData = [
            'name' => 'Another status'
        ];
        $response = $this->patch(route('statuses.update', $this->status), $newStatusData);
        $response->assertRedirect();
        $this->assertDatabaseHas('task_statuses', [
            'id' => $this->status->id,
            'name' => $newStatusData['name']
        ]);
        $this->assertDatabaseMissing('task_statuses', [
            'name' => $this->status->name
        ]);
    }
}
