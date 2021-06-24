<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminRoom extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminRoom Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function init()
    {
        $component = $this->addComponent(
            'Responsiv\Uploader\Components\ImageUploader',
            'layoutUploader',
            ['deferredBinding' => false]
        );

        $component->bindModel('layout', new \Ams\Location\Models\Room);
    }

    public function getAll()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $roomIds     = $userManager->getRoomIds();
        return \Ams\Location\Models\Room::whereIn('id', $roomIds)->orderBy('name')->get();
    }

    public function getOffice()
    {
        $userManager = new \Ams\Core\Classes\UserManager;
        $officeIds   = $userManager->getOfficeIds();
        return \Ams\Location\Models\Office::whereIn('id', $officeIds)->orderBy('name')->get();
    }

    public function getBuilding($officeId=null)
    {
        return \Ams\Location\Models\Building::whereOfficeId($officeId)->orderBy('name')->get();
    }

    public function onSelectOffice()
    {
        $this->page['buildings'] = $this->getBuilding(post('office_id'));
    }

    public function onSave()
    {
        $room              = new \Ams\Location\Models\Room;
        $room->building_id = post('building_id');
        $room->name        = post('name');
        $room->save();

        \Flash::success('Ruangan berhasil disimpan');
        return \Redirect::to('room');
    }

    public function onDelete()
    {
        $room = \Ams\Location\Models\Room::whereParameter(post('parameter'))->first()->delete();
        \Flash::success('Ruangan berhasil dihapus');
        return \Redirect::refresh();
    }
}
