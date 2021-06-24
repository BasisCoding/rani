<?php namespace Ams\Api\Controllers;

use Ams\API\Classes\ApiController;

use Ams\Api\Transformers\ReminderTransformer;

class Reminders extends ApiController
{
    public function index()
    {
        $reminder = \Ams\Asset\Models\Reminder::orderBy('id', 'desc')->get();

        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithCollection($reminder, new ReminderTransformer)
        ]);
    }

    public function detail()
    {
        $reminder = \Ams\Asset\Models\Reminder::find(input('id'));

        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithItem($reminder, new ReminderTransformer)
        ]);
    }
}
