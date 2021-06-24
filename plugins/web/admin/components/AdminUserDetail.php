<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminUserDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminUserDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminUserDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $user = $this->getCurrent();
        if(!$user) {

            return;
        }

        $this->page['user'] = $user;
    }

    public function getCurrent()
    {
        return \Ams\User\Models\User::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $rules = [
            'is_admin' => 'in:0,1',
            'name'     => 'required',
            'email'    => 'required|email',
        ];
        $attributeNames = [
            'name'  => 'nama',
            'email' => 'email',
        ];
        $messages  = [];

        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);
        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $user           = $this->getCurrent();
        $user->name     = post('name');
        $user->email    = post('email');
        $user->save();

        \Flash::success('Petugas berhasil disimpan');
        return \Redirect::to('officer');
    }
}
