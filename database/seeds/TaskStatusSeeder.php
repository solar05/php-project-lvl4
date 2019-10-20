<?php

use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    protected $statuses = ['created', 'in_work', 'testing', 'completed'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->statuses as $status) {
            $dbStatusRecord = new \Task_Manager\TaskStatus();
            $dbStatusRecord->name = $status;
            $dbStatusRecord->save();
        }
    }
}
