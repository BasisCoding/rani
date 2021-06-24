<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminLetter extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminLetter Component',
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

    public function getUser()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        return $userManager->getUser();
    }

    public function getAll()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $officeIds   = $userManager->getOfficeIds();
        return \Ams\Letter\Models\Letter::whereIn('office_id', $officeIds)->get();
    }

    public function onSave()
    {
        $rules = [
            'document'  => 'required',
            'number'    => 'required',
            'office_id' => 'required',
        ];
        $attributeNames = [
            'document'  => 'berkas',
            'number'    => 'kode',
            'office_id' => 'kantor',
        ];
        $messages  = [];
        $validator = \Validator::make(\Input::all(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $file       = new \System\Models\File;
        $file->data = \Input::file('document');
        $file->save();

        $user                = $this->getUser();
        $letter              = new \Ams\Letter\Models\Letter;
        $letter->employee_id = $user->id;
        $letter->number      = post('number');
        $letter->office_id   = post('office_id');
        $letter->description = 'wew';
        $letter->save();
        $letter->document()->add($file);

        \Flash::success('Berita berhasil disimpan');
        return \Redirect::to('/letter');
    }
}
