<?php namespace Web\Admin\Components;

use Carbon\Carbon;

use Cms\Classes\ComponentBase;

class AdminDashboard extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'AdminDashboard Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {

        $this->page['currentYear'] = date('Y');
    }

    public function getEmployee()
    {
        return \Ams\Employee\Models\Employee::get();
    }

    public function getAsset()
    {
        return \Ams\Asset\Models\AssetItem::get();
    }

    public function getReport()
    {
        return \Ams\Report\Models\Report::get();
    }

    public function getDateArray()
    {
        $dates   = [];
        $x       = 10;
        $current = date('Y');

        for ($i=0; $i < $x; $i++) {
            // array_push($dates, Carbon::parse($current)->SubYear($i)->format('Y'));
        }

        return $dates;
        return [];
    }

    public function getAssetTimeline($date)
    {
        $timelines = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($timelines as $key => $timeline) {
            $asset['timelines']['lable'][$key] = $timelines[$key];
            if($key < 10) {
                $key = '0'.($key+1);
            }
            else {
                $key = $key + 1;
            }
            $asset['timelines']['data'][$key] = \Ams\Asset\Models\AssetItem::where('acquisitioned_at', 'like', '%'.$date.'-'.$key.'%')->get()->count();
        }

        return $asset['timelines'];
    }

    public function getReportTimeline($date)
    {
        $timelines = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($timelines as $key => $timeline) {
            $asset['timelines']['lable'][$key] = $timelines[$key];
            if($key < 10) {
                $key = '0'.($key+1);
            }
            else {
                $key = $key + 1;
            }
            $asset['timelines']['data'][$key] = \Ams\Report\Models\Report::where('created_at', 'like', '%'.$date.'-'.$key.'%')->get()->count();
        }

        return $asset['timelines'];
    }

    public function onChangeAssetTimelineFilter()
    {
        $this->page['timelines'] = $this->getAssetTimeline(post('date'));
    }

    public function onChangeReportTimelineFilter()
    {
        $this->page['timelines'] = $this->getReportTimeline(post('date'));
    }
}
