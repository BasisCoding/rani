<?php namespace Web\Auth\Components;

use Cms\Classes\ComponentBase;

class Auth extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Auth Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getUser()
    {
        $user = new \Ams\Core\Classes\UserManager;
        return $user->getUser();
    }

    public function onLogin()
    {
        $rules = [
            'nik'       => 'required',
            'password'  => 'required',
        ];
        $attributeNames = [
            'nik'       => 'nomor induk',
            'password'  => 'password',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $user = \Ams\User\Models\User::whereNik(post('nik'))->first();
        if(!$user) {
            \Flash::error('Pengguna tidak ditemukan');
            return;
        }

        if(!\Hash::check(post('password'), $user->password)) {
            \Flash::error('Password tidak sesuai');
            return;
        }

        $session = new \Ams\Core\Classes\UserManager;
        $session->setUser($user->id);

        if(input('callback')) {
            return \Redirect::to(input('callback'));
        }

        return \Redirect::to('dashboard');
    }

    public function onLogout()
    {
        $session = new \Ams\Core\Classes\UserManager;
        $session->removeUser();

        \Flash::success('Berhasil keluar');
        return \Redirect::to('/');
    }

    public function onUpdateProfile()
    {
        $rules = [
            'name'  => 'required',
            'email' => 'required|email',
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

        $user        = $this->getUser();
        $user->name  = post('name');
        $user->email = post('email');
        $user->save();

        \Flash::success('Profile berhasil disimpan');
        return \Redirect::refresh();
    }

    public function onUpdatePassword()
    {
        $rules = [
            'password_old'    => 'required',
            'password'        => 'required|min:6',
            'password_retype' => 'required|same:password',
        ];
        $attributeNames = [
            'password_old'    => 'password lama',
            'password'        => 'password baru',
            'password_retype' => 'ulangi password',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $user           = $this->getUser();
        $user->password = \Hash::make(post('password'));
        $user->save();

        $session        = new \Ams\Core\Classes\UserManager;
        $session->removeUser();

        \Flash::success('Password berhasil diubah');
        return \Redirect::refresh();
    }
}
