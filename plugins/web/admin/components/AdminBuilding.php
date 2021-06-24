<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminBuilding extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminBuilding Component',
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
        $officeIds   = $userManager->getOfficeIds();
        return \Ams\Location\Models\Building::whereIn('office_id', $officeIds)->orderBy('name')->get();
    }

    public function onSave()
    {
        $building            = new \Ams\Location\Models\Building;
        $building->office_id = post('office_id');
        $building->name      = post('name');
        $building->save();

        \Flash::success('Gedung berhasil disimpan');
        return \Redirect::to('building');
    }

    public function onDelete()
    {
        $building   = \Ams\Location\Models\Building::whereParameter(post('parameter'))->first();
        $building->delete();

        \Flash::success('Gedung berhasil dihapus');
        return \Redirect::refresh();
    }
}
