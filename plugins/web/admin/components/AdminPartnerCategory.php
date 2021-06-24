<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminPartnerCategory extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminPartnerCategory Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Partner\Models\Category::orderBy('id', 'desc')->get();
    }

    public function onSave()
    {
        $rules = [
            'name'  => 'required',
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

        $category        = new \Ams\Partner\Models\Category;
        $category->name  = post('name');
        $category->save();

        \Flash::success('Kategori berhasil disimpan');
        return \Redirect::to('partner-category');
    }

    public function onDelete()
    {
        $partner = \Ams\Partner\Models\Category::whereParameter(post('parameter'))->first();
        $partner->delete();

        \Flash::success('Kategori berhasil dihapus');
        return \Redirect::refresh();
    }
}
