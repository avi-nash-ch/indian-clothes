<?php
namespace App\Traits;
use Exception;

trait PushNotification
{
    public function send_notification($request, $fcm_token, $user_type = 1)
    {
        $credentialsFilePath = "firebase/fcm.json";
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $apiurl = 'https://fcm.googleapis.com/v1/projects/gharkabazaar-4e1f5/messages:send';
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];
        
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        // Ensure title and body are available in the request
        if (!isset($request['title']) || !isset($request['body'])) {
            throw new Exception('Notification title or body is missing');
        }

        // Notification payload (for background notifications)
        $notification = [
            "title" => $request['title'],
            "body"  => $request['body'],
        ];

        // Custom data payload (if you need to pass additional data)
        $data = [
            "title" => $request['title'],
            "body"  => $request['body'],
            "user_type" => (string) $user_type,
        ];

        // FCM message structure
        $payload = [
            'message' => [
                'token' => $fcm_token,  // FCM token of the device
                'notification' => $notification,  // Notification for background display
                'data' => $data,  // Custom data for internal use
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound' => 'deliverynotification', // Custom sound for Android
                        'channel_id' => 'deliveryNotification1',  // Channel ID
                    ],
                ],
            ],
        ];

        $payload = json_encode($payload);

        // Send the notification via cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $response;
    }
}
