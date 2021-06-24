<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminEmployeeDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminEmployeeDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminEmployeeDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $employee = $this->getCurrent();
        if(!$employee) {

            return;
        }

        $this->page['employee'] = $employee;
    }

    public function getCurrent()
    {
        return \Ams\Employee\Models\Employee::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $employee                = $this->getCurrent();
        $employee->office_id     = post('office_id');
        $employee->code          = post('code');
        $employee->name          = post('name');
        $employee->department_id = post('department_id');
        $employee->team_id       = post('team_id');
        $employee->unit_id       = post('unit_id');
        $employee->save();

        \Flash::success('Pengguna berhasil disimpan');
        return \Redirect::to('employee');
    }
}
