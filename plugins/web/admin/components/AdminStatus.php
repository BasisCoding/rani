<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminStatus extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminStatus Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Asset\Models\Status::orderBy('name')->get();
    }

    public function onSave()
    {
        $asset              = new \Ams\Asset\Models\Status;
        $asset->name        = post('name');
        $asset->color       = post('color');
        $asset->description = post('description');
        $asset->save();

        \Flash::success('Status berhasil disimpan');
        return \Redirect::to('status');
    }
}
