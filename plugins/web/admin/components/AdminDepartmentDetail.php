<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminDepartmentDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminDepartmentDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminDepartmentDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $department = $this->getCurrent();
        if(!$department) {

            return;
        }

        $userManager = new \Ams\Core\Classes\UserManager;
        $officeIds   = $userManager->getOfficeIds();
        $this->page['offices']    = \Ams\Location\Models\Office::whereIn('id', $officeIds)->get();
        $this->page['department'] = $department;
    }

    public function getCurrent()
    {
        return \Ams\Employee\Models\Department::whereParameter($this->property('parameter'))->first();
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

        $department             = $this->getCurrent();
        $department->office_id  = post('office_id');
        $department->name       = post('name');
        $department->save();

        \Flash::success('Department berhasil disimpan');
        return \Redirect::to('department');
    }
}
