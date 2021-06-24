<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminPartnerCategoryDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminPartnerCategoryDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminPartnerCategoryDetail Component',
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
        return \Ams\Partner\Models\Category::whereParameter($this->property('parameter'))->first();
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

        $category        = $this->getCurrent();
        $category->name  = post('name');
        $category->save();

        \Flash::success('Kategori berhasil disimpan');
        return \Redirect::to('partner-category');
    }
}
