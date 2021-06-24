<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminSupplierDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminSupplierDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminSupplierDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $supplier = $this->getCurrent();
        if(!$supplier) {

            return;
        }

        $this->page['supplier'] = $supplier;
    }

    public function getCurrent()
    {
        return \Ams\Supplier\Models\Supplier::whereParameter($this->property('parameter'))->first();
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

        $supplier        = $this->getCurrent();
        $supplier->name  = post('name');
        $supplier->phone = post('phone');
        $supplier->email = post('email');
        $supplier->save();

        \Flash::success('Pemasok berhasil disimpan');
        return \Redirect::to('supplier');
    }
}
