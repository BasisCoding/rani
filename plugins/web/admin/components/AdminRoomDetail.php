<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminRoomDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminRoomDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminRoomDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function init()
    {
        $room      = $this->getCurrent();
        $component = $this->addComponent(
            'Responsiv\Uploader\Components\ImageUploader',
            'layoutUploader',
            ['deferredBinding' => false]
        );

        $component->bindModel('layout', \Ams\Location\Models\Room::find($room->id));
    }

    public function onRun()
    {
        $room = $this->getCurrent();
        if(!$room) {

            return;
        }

        $this->page['room'] = $room;
    }

    public function getCurrent()
    {
        return \Ams\Location\Models\Room::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $room              = $this->getCurrent();
        $room->building_id = post('building_id');
        $room->name        = post('name');
        $room->save();

        \Flash::success('Ruangan berhasil disimpan');
        return \Redirect::to('room');
    }
}
