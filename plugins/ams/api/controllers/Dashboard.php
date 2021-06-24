<?php namespace Ams\Api\Controllers;

use Carbon\Carbon;

use Ams\API\Classes\ApiController;

class Dashboard extends ApiController
{
    public function index()
    {
        $assets = new \Ams\Asset\Models\AssetItem;
        $reports= new \Ams\Report\Models\Report;
        $dates  = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $limit      = 10;
        $years      = [];
        $year       = post('year');
        $assetYear  = post('year_asset');
        $reportYear = post('year_report');

        for ($i=0; $i < $limit; $i++) {
            array_push($years, Carbon::parse($year)->subYear($i)->format('Y'));
        }

        // Asset Timelines
        foreach ($dates as $key => $timeline) {
            $keyCalendar = $key + 1;
            if($keyCalendar < 10) {
                $keyCalendar = '0'.$keyCalendar;
            }

            $asset['timelines']['date'][$key]  = $dates[$key];
            $asset['timelines']['lable'][$key] = substr($dates[$key], 0,3);
            $asset['timelines']['data'][$key]  = $assets->where('acquisitioned_at', 'like', '%'.$assetYear.'-'.$keyCalendar.'%')->count();
        }

        // Report Timelines
        foreach ($dates as $key => $timeline) {
            $keyCalendar = $key + 1;
            if($keyCalendar < 10) {
                $keyCalendar = '0'.$keyCalendar;
            }
            $report['timelines']['date'][$key]  = $dates[$key];
            $report['timelines']['lable'][$key] = substr($dates[$key], 0,3);
            $report['timelines']['data'][$key]  = $reports->where('created_at', 'like', '%'.$reportYear.'-'.$keyCalendar.'%')->count();
        }

        return response()->json([
            'result'    => true,
            'response'  => [
                'year'  => [
                    'current'  => $year,
                    'selected' => [
                        'asset'  => $assetYear,
                        'report' => $reportYear
                    ],
                    'data' => $years
                ],
                'asset' => [
                    'timeline'  => [
                        'data'  => $asset['timelines']['data'],
                        'lable' => $asset['timelines']['lable'],
                        'date'  => $asset['timelines']['date'],
                        'year'  => $year,
                    ],
                    'total'     => $assets->count()
                ],
                'report' => [
                    'timeline'  => [
                        'data'  => $report['timelines']['data'],
                        'lable' => $report['timelines']['lable'],
                        'date'  => $report['timelines']['date'],
                        'year'  => $year,
                    ],
                    'total'     => $reports->count()
                ],
            ],
        ]);
    }
}
