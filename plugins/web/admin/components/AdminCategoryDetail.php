<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminCategoryDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminCategoryDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminCategoryDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $category = $this->getCurrent();
        if(!$category) {

            return;
        }

        $this->page['category'] = $category;
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\Category::whereParameter($this->property('parameter'))->first();
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

        $category       = $this->getCurrent();
        $category->name = post('name');
        $category->code = post('code');
        $category->save();

        \Flash::success('Kategori berhasil disimpan');
        return \Redirect::to('category');
    }
}
