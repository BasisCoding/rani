<?php namespace Ams\Core\Console;

use Carbon\Carbon;

use Illuminate\Console\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Ams\Core\Classes\Notification;

class PushReminder extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'ams:push-reminder';

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
        $reminders = \Ams\Asset\Models\Reminder::whereDate('reminded_at', 'like', $now)->get();

        /**
         * Get all users
        */
        $users    = \Ams\User\Models\User::whereIn('is_admin', [0, 1])->select('id')->get()->toArray();
        $users    = \Ams\User\Models\Token::whereIn('user_id', $users)->get();

        foreach ($reminders as $reminder) {
            foreach ($users as $user) {
                $body    = $reminder->name.' akan berlangsung hari ini';
                $content = [
                    'title' => 'Pemberitahuan Pengingat',
                    'body'  =>  $body,
                    'application' => [
                        'page'      => 'ReminderDetail',
                        'parameter' => 'reminderId',
                        'key'       => $reminder->id
                    ]
                ];

                $notification = new Notification;
                $notification->pulse([$user->token], $content);
                $this->info('Reminder sent to '.$user->user->name.' device');

                if($reminder->type == 'repeat') {
                    $reminder->reminded_at = Carbon::parse($reminder->reminded_at)->addDays(30)->format('Y-m').'-'.Carbon::parse($reminder->reminded_at)->format('d');
                    $reminder->save();
                }
            }
        }
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
