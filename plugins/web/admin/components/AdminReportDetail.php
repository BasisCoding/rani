<?php namespace Web\Admin\Components;

use Cms\Classes\ComponentBase;

class AdminReportDetail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminReportDetail Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'parameter' => [
                'name'        => 'AdminReportDetail Component',
                'description' => 'No description provided yet...'
            ]
        ];
    }

    public function onRun()
    {
        $report = $this->getCurrent();
        if(!$report) {

            return;
        }

        $this->page['report'] = $report;
    }

    public function getCurrent()
    {
        return \Ams\Report\Models\Report::whereParameter($this->property('parameter'))->first();
    }

    public function onFinished()
    {
        $report              = $this->getCurrent();
        $report->is_finished = 1;
        $report->save();

        /**
         * Get all users
        */
        $body    = $report->user->name.' , laporan anda ditandai sudah selesai.';
        $content = [
            'title' => 'Laporan Selesai',
            'body'  =>  $body,
            'application' => [
                'page'      => 'ReportDetail',
                'parameter' => 'reportId',
                'key'       => $report->id
            ]
        ];

        $notification = new \Ams\Core\Classes\Notification;
        $notification->pulse([$report->user->token], $content);

        \Flash::success('Laporan berhasil diselesaikan');
        return \Redirect::refresh();
    }
}
