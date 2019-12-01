<?php


namespace Task_Manager\Traits;
use Laracasts\Presenter\Presenter;
use Task_Manager\TaskStatus;


class StatePresenter extends Presenter
{
    public function stateName()
    {
        if (TaskStatus::isSystemStatus($this->name)) {
            return trans("state.{$this->name}");
        }
        return $this->name;
    }

    public function stateBadgeClass()
    {
        $stateMap = [
            'created' => 'badge badge-primary',
            'in_work' => 'badge badge-info',
            'testing' => 'badge badge-warning',
            'completed' => 'badge badge-success',
        ];
        if (TaskStatus::isSystemStatus($this->name)) {
            return $stateMap[$this->name];
        }
        return 'badge badge-secondary';
    }
}
