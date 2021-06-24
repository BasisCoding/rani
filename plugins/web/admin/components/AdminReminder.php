<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminReminder extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminReminder Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Asset\Models\Reminder::orderBy('created_at', 'desc')->get();
    }

    public function getAsset()
    {
        return \Ams\Asset\Models\AssetItem::orderBy('id', 'asc')->get();
    }

    public function onSelectType()
    {
        $this->page['type'] = post('type');
    }

    public function onSave()
    {
        $rules     = [
            'name'          => 'required',
            'reminded_at'   => 'required',
            'type'          => 'required|in:once,repeat'
        ];
        $attributeNames = [
            'name'          => 'nama',
            'reminded_at'   => 'tanggal',
            'type'          => 'informasi pengingat'
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

        $reminder              = new \Ams\Asset\Models\Reminder;
        $reminder->name        = post('name');
        $reminder->description = post('description');
        $reminder->type        = post('type');
        $reminder->reminded_at = post('reminded_at');
        $reminder->save();
        $reminder->assets()->sync(post('asset_id'));

        \Flash::success('Pengingat berhasil disimpan');
        return \Redirect::to('/reminder');
    }

    public function onDelete()
    {
        $reminder = \Ams\Asset\Models\Reminder::whereParameter(post('parameter'))->first();
        $reminder->assets()->detach();
        $reminder->delete();

        \Flash::success('Pengingat berhasil dihapus');
        return \Redirect::refresh();
    }
}
