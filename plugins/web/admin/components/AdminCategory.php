<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminCategory extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminCategory Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Asset\Models\Category::whereNull('parent_id')->orderBy('name')->get();
    }

    public function onSave()
    {
        $rules     = [
            'name' => 'required',
            'code' => 'required|max:2',
        ];
        $attributeNames = [
            'name' => 'nama',
            'code' => 'kode',
        ];
        $messages  = [];

        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);
        if ($validator->fails()) {
            \Flash::error($validator->messages()->first());
            return;
        }

        $category       = new \Ams\Asset\Models\Category;
        $category->name = post('name');
        $category->code = post('code');
        $category->save();

        \Flash::success('Kategori berhasil disimpan');
        return \Redirect::to('category');
    }

    public function onDelete()
    {
        $category = \Ams\Asset\Models\Category::whereParameter(post('parameter'))->first()->delete();

        \Flash::success('Kategori berhasil dihapus');
        return \Redirect::to('category');
    }
}
