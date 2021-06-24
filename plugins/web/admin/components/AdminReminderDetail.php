<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminReminderDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminReminderDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminReminderDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $reminder = $this->getCurrent();
        if(!$reminder) {

            return;
        }

        $this->page['reminder'] = $reminder;
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\Reminder::whereParameter($this->property('parameter'))->first();
    }

    public function onSave()
    {
        $rules     = [
            'name'          => 'required',
            'reminded_at'   => 'required',
        ];
        $attributeNames = [
            'name'          => 'nama',
            'reminded_at'   => 'tanggal',
        ];
        $messages  = [];

        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);
        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        if(!count(post('asset_id'))) {
            \Flash::error('Asset belum dipilih');
            return;
        }

        $reminder              = $this->getCurrent();
        $reminder->name        = post('name');
        $reminder->description = post('description');
        $reminder->reminded_at = post('reminded_at');
        $reminder->save();
        $reminder->assets()->sync(post('asset_id'));

        \Flash::success('Pengingat berhasil disimpan');
        return \Redirect::to('/reminder');
    }
}
