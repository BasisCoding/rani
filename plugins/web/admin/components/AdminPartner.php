<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminPartner extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminSupplier Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Partner\Models\Partner::get();
    }

    public function getCategory()
    {
        return \Ams\Partner\Models\Category::orderBy('name', 'asc')->get();
    }

    public function onSave()
    {
        $rules = [
            'name'  => 'required',
            'email' => 'email',
        ];
        $attributeNames = [
            'name'  => 'nama',
        ];
        $messages  = [];
        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);

        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $partner        = new \Ams\Partner\Models\Partner;
        $partner->name  = post('name');
        $partner->phone = post('phone');
        $partner->email = post('email');
        $partner->save();

        if(post('category_id')) {
            $partner->categories()->sync(post('category_id'));
        }

        \Flash::success('Mitra berhasil disimpan');
        return \Redirect::to('partner');
    }

    public function onDelete()
    {
        $partner = \Ams\Partner\Models\Partner::whereParameter(post('parameter'))->first();
        $partner->delete();

        \Flash::success('Mitra berhasil dihapus');
        return \Redirect::refresh();
    }
}
