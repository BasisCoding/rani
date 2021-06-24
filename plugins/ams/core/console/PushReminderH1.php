<?php namespace Ams\Core\Console;

use Carbon\Carbon;

use Illuminate\Console\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Ams\Core\Classes\Notification;

class PushReminderH1 extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'ams:push-reminder-h1';

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
        /**
         * Get reminders
        */
        $now       = date('Y-m-d');
        $h1        = Carbon::parse($now)->addDays(1)->format('Y-m-d');
        $reminders = \Ams\Asset\Models\Reminder::whereDate('reminded_at', 'like', $h1)->get();

        /**
         * Get all users
        */
        $users    = \Ams\User\Models\User::whereIn('is_admin', [0, 1])->select('id')->get()->toArray();
        $users    = \Ams\User\Models\Token::whereIn('user_id', $users)->get();

        foreach ($reminders as $reminder) {
            foreach ($users as $user) {
                $body    = $reminder->name.' akan berlangsung untuk esok hari';
                $content = [
                    'title'       => 'Pemberitahuan Pengingat',
                    'body'        => $body,
                    'application' => [
                        'page'      => 'ReminderDetail',
                        'parameter' => 'reminderId',
                        'key'       => $reminder->id
                    ]
                ];

                $notification = new Notification;
                $notification->pulse([$user->token], $content);
                $this->info('Reminder sent to '.$user->user->name.' device');
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
