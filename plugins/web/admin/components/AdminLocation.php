<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminLocation extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminLocation Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Location\Models\Location::orderBy('name')->get();
    }
}
