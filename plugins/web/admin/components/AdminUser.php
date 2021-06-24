<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminUser extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminUser Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\User\Models\User::get();
    }

    public function onSave()
    {
        $rules = [
            'is_admin'        => 'in:0,1',
            'name'            => 'required',
            // 'email'           => 'required|email|exists:ams_user_users,email',
            'password'        => 'required|min:6',
            'password_retype' => 'required|same:password'
        ];
        $attributeNames = [
            'name'            => 'nama',
            'email'           => 'email',
            'password'        => 'password',
            'password_retype' => 'ulangi password'
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $user           = new \Ams\User\Models\User;
        $user->name     = post('name');
        $user->email    = strtolower(post('email'));
        $user->plain    = strtolower(post('password'));
        $user->password = \Hash::make($user->plain);
        $user->save();

        \Flash::success('Petugas berhasil disimpan');
        return \Redirect::to('officer');
    }

    public function onDelete()
    {
        $user = \Ams\User\Models\User::whereParameter(post('parameter'))->first();
        $user->tokens()->delete();
        $user->delete();

        \Flash::success('Petugas berhasil dihapus');
        return \Redirect::to('officer');
    }
}
