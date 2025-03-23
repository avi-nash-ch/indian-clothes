<?php
use Illuminate\Support\Facades\Storage;

// Get Image
function getImageUrl($imagePath)
{
    $image = '';
    if (config('app.env') === 'prod') {
        // s3 will implement later
        /*$exists = Storage::disk(env("UPLOAD_DRIVER", "public"))->exists($imagePath);

        if ($exists) {
            //get content of image
            $content = Storage::disk(env("UPLOAD_DRIVER", "public"))->get($imagePath);
            //get mime type of image
            $mime = Storage::mimeType($imagePath);
            //prepare response with image content and response code
            $response = Response::make($content, 200);
            //set header
            $response->header("Content-Type", $mime);
            // return response
            $image = $response;
        }*/
    } else {
        $image = asset(Storage::url($imagePath));
    }

    return $image;
}


function uploadImage($path, $file)
{
    return Storage::disk(env('UPLOAD_DRIVER', 'public'))->put($path, file_get_contents($file), 'public');
}

function deleteImage($imagePath)
{
    if ($imagePath && Storage::disk(env('UPLOAD_DRIVER', 'public'))->exists($imagePath)) {
        Storage::disk(env('UPLOAD_DRIVER', 'public'))->delete($imagePath);
    }
}





function push_notification_android($device_id, $message)
{
    //API URL of FCM
    $url = 'https://fcm.googleapis.com/fcm/send';

    /*api_key available in:
    Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    $api_key = 'AAAAqCXB3LM:APA91bGYaj7vHbboU_2KrlgFtfojkNyvCW6icI_MqeKgTMm5IUO4oPfcIViymbtfyQofZQtoRpE-VbvVesNCIWxfqJpA6lSh30muKDbwXpPq3qIq7V4nRfOZCkQDg_U336Z4BV_KNiqJ';

    $fields = array(
        'registration_ids' => (is_array($device_id))?$device_id:[$device_id],
        'data' => array(
                "message" => $message,
                "title"=>"New Order Assigned",
                "body"=>$message
        )
    );
    // print_r($fields);
    // exit;
    //header includes Content type and api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$api_key
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === false) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    // echo $result;
    // exit;
    return $result;
}

function Send_OTP($MobileNo, $OTP)
{
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localsmsindia.com/api/smsapi?key=b3c22618e44631fbcd838b8369bf7b08&route=2&sender=GKBZAR&number="'.$MobileNo.'"&templateid=1307171215691630421&sms="'.$OTP.'"%20is%20the%20OTP%20for%20your%20verify%20mobile%20number%20on%20Ghar%20Ka%20Bazaar.%20Please%20do%20not%20share%20this%20OTP%20with%20anyone.%20Best%20Wishes%2C%20Team%20Ghar%20Ka%20Bazaar.',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: ci_session=thttk3497imagco0bkgl371ajp8fkf9n'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
}
function Send_OTP_for_Delivery($MobileNo, $OTP)
{
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localsmsindia.com/api/smsapi?key=b3c22618e44631fbcd838b8369bf7b08&route=2&sender=GKBZAR&number="'.$MobileNo.'"&templateid=1307172503274884521&sms=Your%20OTP%20for%20confirming%20the%20delivery%20of%20your%20order%20is"'.$OTP.'"%20Please%20provide%20this%20code%20to%20the%20delivery%20agent.%20Team%20Ghar%20Ka%20Bazaar',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: ci_session=thttk3497imagco0bkgl371ajp8fkf9n'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;
}

