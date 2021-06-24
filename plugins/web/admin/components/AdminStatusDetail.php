<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminStatusDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminStatusDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminStatusDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $status = $this->getCurrent();
        if(!$status) {

            return;
        }

        $this->page['status'] = $status;
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\Status::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $status              = $this->getCurrent();
        $status->name        = post('name');
        $status->color       = post('color');
        $status->description = post('description');
        $status->save();

        \Flash::success('Status berhasil disimpan');
        return \Redirect::to('status');
    }
}
