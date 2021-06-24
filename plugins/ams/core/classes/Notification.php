<?php namespace Ams\Core\Classes;

/**
 * Core Plugin Information File
 */
class Notification
{
    public function pulse($token, $body)
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

        if($body['application']) {
            $notification['application'] = $body['application'];
        }

        // array_push($notification, ['notification' => $notification]);
        $fcmNotification = [
            'registration_ids' => $token,
            'data'             => $notification,
            // 'notification'     => $notification
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
}
