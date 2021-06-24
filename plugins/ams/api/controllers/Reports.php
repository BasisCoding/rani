<?php namespace Ams\Api\Controllers;

use Ams\API\Classes\ApiController;

use Ams\Api\Transformers\ReportTransformer;

class Reports extends ApiController
{
    public function index()
    {
        $id     = input('user_id');
        $report = \Ams\Report\Models\Report::whereUserId($id)->orderBy('id', 'desc')->get();

        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithCollection($report, new ReportTransformer)
        ]);
    }

    public function detail()
    {
        $id     = input('id');
        $report = \Ams\Report\Models\Report::find($id);

        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithItem($report, new ReportTransformer)
        ]);
    }
}
