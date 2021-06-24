<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminLetterDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminLetterDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminLetterDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $letter               = $this->getCurrent();
        $this->page['letter'] = $letter;
    }

    public function getCurrent()
    {
        return \Ams\Letter\Models\Letter::whereParameter($this->property('parameter'))->first();
    }
}
