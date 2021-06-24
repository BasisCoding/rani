<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminReport extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminReport Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function getAll()
    {
        return \Ams\Report\Models\Report::get();
    }

    public function onDelete()
    {
        $report = \Ams\Report\Models\Report::whereParameter(post('parameter'))->first();
        $report->attachments()->delete();
        $report->delete();

        \Flash::success('Laporan berhasil dihapus');
        return \Redirect::refresh();
    }
}
