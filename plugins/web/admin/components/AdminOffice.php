<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminOffice extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminOffice Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        return $userManager->getOffice();
        // return \Ams\Location\Models\Office::orderBy('name')->get();
    }

    public function onSave()
    {
        $office              = new \Ams\Location\Models\Office;
        $office->name        = post('name');
        $office->code        = post('code');
        $office->province_id = post('province_id');
        $office->regency_id  = post('regency_id');
        $office->district_id = post('district_id');
        $office->village_id  = post('village_id');
        $office->address     = post('address');
        $office->save();

        \Flash::success('Kantor berhasil disimpan');
        return \Redirect::to('office');
    }

    public function onDelete()
    {
        $office = \Ams\Location\Models\Office::whereParameter(post('parameter'))->first()->delete();
        \Flash::success('Kantor berhasil dihapus');
        return \Redirect::refresh();
    }
}
