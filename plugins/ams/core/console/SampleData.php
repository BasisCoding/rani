<?php namespace Ams\Core\Console;

use Illuminate\Console\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

// use LaravelFCM\Message\OptionsBuilder;
// use LaravelFCM\Message\PayloadDataBuilder;
// use LaravelFCM\Message\PayloadNotificationBuilder;
// use FCM;

class SampleData extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'ams:up';

    /**
     * @var string The console command description.
     */
    protected $description = 'Does something cool.';

    /**
     * Execute the console command.
     * @return void
    */
    public function handle()
    {
        // $reminder = \Ams\Asset\Models\Reminder::get();
        // $user     = \Ams\User\Models\User::whereIsAdmin(1)->select('id')->get()->toArray();
        // $user     = \Ams\User\Models\Token::whereIn('user_id', $user)->select('token')->get();
        // foreach ($reminder as $r) {
        //     foreach ($user as $us) {
        //         $content = [
        //             'title' => 'Pemberitahuan Pengingat',
        //             'body'  => $r->name.' untuk '.$r->assets->count().' assets anda'
        //         ];

        //         $this->notification([$us->token], $content);
        //     }
        // }
        //

        $report = \Ams\Report\Models\Report::get();
        $user   = \Ams\User\Models\User::whereIsAdmin(1)->select('id')->get()->toArray();
        $user   = \Ams\User\Models\Token::whereIn('user_id', $user)->select('token')->get();


        foreach ($report as $r) {
            foreach ($user as $us) {
                $content = [
                    'title' => 'Laporan Baru',
                    'body'  => $r->user->name.' membuat laporan '.$r->asset->name
                ];

                $this->notification([$us->token], $content);
            }
        }
    }

    /**
     * Execute the console command.
     * @return void
    */
    public function notification($token, $body)
    {
        $fcmUrl  = 'https://fcm.googleapis.com/fcm/send';
        $headers = [
            'Authorization: key=AIzaSyCN7c7kBuH5sDAyaVVPKONAVGnkKx273jw',
            'Content-Type: application/json'
        ];

        $notification = [
            'title'              => $body['title'],
            'body'               => $body['body'],
            'color'              => '#009cff',
            'priority'           => 'high',
            'icon'               => 'ic_launcher',
            'show_in_foreground' => true,
            'show_in_background' => true,
        ];

        // array_push($notification, ['notification' => $notification]);
        $fcmNotification = [
            'registration_ids' => $token,
            // 'data'             => $notification,
            'notification'     => $notification
        ];
        // array_push($fcmNotification, $notification);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
