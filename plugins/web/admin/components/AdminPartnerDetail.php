<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminPartnerDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminPartnerDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminPartnerDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $partner = $this->getCurrent();
        if(!$partner) {

            return;
        }

        $this->page['partner'] = $partner;
    }

    public function getCurrent()
    {
        return \Ams\Partner\Models\Partner::whereParameter($this->property('parameter'))->first();
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

        $partner        = $this->getCurrent();
        $partner->name  = post('name');
        $partner->phone = post('phone');
        $partner->email = post('email');
        $partner->save();

        if(post('category_id')) {
            $partner->categories()->sync(post('category_id'));
        }
        else {
            $partner->categories()->detach();
        }

        \Flash::success('Mitra berhasil disimpan');
        return \Redirect::to('partner');
    }
}
