<?php namespace Ams\Core\Classes;

class EmployeeHelpers
{
    public function getDepartment()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $officeIds   = $userManager->getOfficeIds();
        return \Ams\Employee\Models\Department::whereIn('office_id', $officeIds)->orderBy('name')->get();
    }

    public function getTeam($departmentId)
    {
        return \Ams\Employee\Models\Team::orderBy('name')->whereDepartmentId($departmentId)->get();
    }

    public function getUnit($unitId)
    {
        return \Ams\Employee\Models\Unit::orderBy('name')->whereTeamId($unitId)->get();
    }
}
