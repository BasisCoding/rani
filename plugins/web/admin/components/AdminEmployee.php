<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

use Ams\Employee\Models\Employee as EmployeeModels;

class AdminEmployee extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminEmployee Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $officeIds   = $userManager->getOfficeIds();
        $this->page['offices'] = \Ams\Location\Models\Office::whereIn('id', $officeIds)->get();
    }

    public function getAll()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $officeIds   = $userManager->getOfficeIds();
        return EmployeeModels::whereIn('office_id', $officeIds)->orderBy('name', 'asc')->get();
    }

    public function getDepartment()
    {
        $department = new \Ams\Core\Classes\EmployeeHelpers;
        return $department->getDepartment();
    }

    public function getTeam($departmentId)
    {
        $team = new \Ams\Core\Classes\EmployeeHelpers;
        return $team->getTeam($departmentId);
    }

    public function getUnit($teamId)
    {
        $unit = new \Ams\Core\Classes\EmployeeHelpers;
        return $unit->getUnit($teamId);
    }

    public function onSelectDepartment()
    {
        $this->page['teams'] = $this->getTeam(post('department_id'));
        return;
    }

    public function onSelectTeam()
    {
        $this->page['units'] = $this->getUnit(post('team_id'));
        return;
    }

    public function onSave()
    {
        $rules = [
            'office_id' => 'required',
            'name'      => 'required',
            'code'      => 'required',
        ];
        $attributeNames = [
            'office_id' => 'kantor',
            'name'      => 'nama',
            'code'      => 'nik',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first()
            ]);
        }

        $employee                = new \Ams\Employee\Models\Employee;
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

    public function onDelete()
    {
        $employee = \Ams\Employee\Models\Employee::whereParameter(post('parameter'))->first();
        $employee->delete();

        \Flash::success('Pengguna berhasil dihapus');
        return \Redirect::refresh();
    }
}
