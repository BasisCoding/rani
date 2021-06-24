<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminSupplier extends ComponentBase
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
        return \Ams\Supplier\Models\Supplier::get();
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

        $supplier        = new \Ams\Supplier\Models\Supplier;
        $supplier->name  = post('name');
        $supplier->phone = post('phone');
        $supplier->email = post('email');
        $supplier->save();

        \Flash::success('Pemasok berhasil disimpan');
        return \Redirect::to('supplier');
    }

    public function onDelete()
    {
        $supplier = \Ams\Supplier\Models\Supplier::whereParameter(post('parameter'))->first();
        $supplier->delete();

        \Flash::success('Supplier berhasil dihapus');
        return \Redirect::refresh();
    }
}
