<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminDepartment extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminDepartment Component',
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
        $department = new \Ams\Core\Classes\EmployeeHelpers;
        return $department->getDepartment();
    }

    public function onSave()
    {
        $rules = [
            'office_id' => 'required',
            'name'      => 'required',
        ];
        $attributeNames = [
            'office_id' => 'kantor',
            'name'      => 'nama',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $department             = new \Ams\Employee\Models\Department;
        $department->office_id  = post('office_id');
        $department->name       = post('name');
        $department->save();

        \Flash::success('Department berhasil disimpan');
        return \Redirect::to('department');
    }

    public function onDelete()
    {
        $department = \Ams\Employee\Models\Department::whereParameter(post('parameter'))->first();
        $department->delete();

        \Flash::success('Department berhasil dihapus');
        return \Redirect::to('department');
    }
}
