<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminCategoryItem extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminCategoryItem Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminCategoryItem Component',
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
        $this->page['items']    = $this->getAll();
    }

    public function getCurrent()
    {
        return \Ams\Asset\Models\Category::whereParameter($this->property('parameter'))->first();
    }

    public function getAll()
    {
        $category = $this->getCurrent();
        return \Ams\Asset\Models\Category::whereParentId($category->id)->orderBy('name')->get();
    }

    public function onRequestAdd()
    {
        return;
    }

    public function onRequestEdit()
    {
        $category               = \Ams\Asset\Models\Category::whereParameter(post('parameter'))->first();
        $this->page['category'] = $category;
    }

    public function onSave()
    {
        $rules     = [
            'name' => 'required',
            // 'code' => 'required|max:2',
        ];
        $attributeNames = [
            'name' => 'nama',
            // 'code' => 'kode',
        ];
        $messages  = [];

        $validator = \Validator::make(post(), $rules, $messages, $attributeNames);
        if ($validator->fails()) {
            throw new \Exception($validator->messages()->first());
            return;
        }

        $parent              = $this->getCurrent();
        $category            = \Ams\Asset\Models\Category::firstOrCreate([
            'parameter' => post('parameter')
        ]);
        $category->parent_id = $parent->id;
        $category->name      = post('name');
        $category->save();


        $this->page['category'] = $this->getCurrent();
        $this->page['items']    = $this->getAll();
        \Flash::success('Kategori berhasil disimpan');
        return;
    }

    public function onDelete()
    {
        $category = \Ams\Asset\Models\Category::whereParameter(post('parameter'))->first()->delete();
        \Flash::success('Kategori berhasil dihapus');
        return \Redirect::refresh();
    }
}
