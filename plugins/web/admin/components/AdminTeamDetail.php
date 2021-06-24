<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminTeamDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminTeamDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminTeamDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $team = $this->getCurrent();
        if(!$team) {

            return;
        }

        $this->page['team'] = $team;
    }

    public function getCurrent()
    {
        return \Ams\Employee\Models\Team::whereParameter($this->property('parameter'))->first();
    }
}
