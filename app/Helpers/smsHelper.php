<?php

use App\Models\SmsLog;
use Filament\Notifications\Notification;

function addSMSLog($phone, $sms, $sender, $status, $type)
{
    SmsLog::create([
        'phone' => $phone,
        'msg' => $sms,
        'sender_id' => $status,
        'status' => $status,
        'type'=>$type,
    ]);
}
function number_validation($number) {

    $number = str_replace(' ', '', $number);
    $number = str_replace('-', '', $number);

    if (preg_match('/^(\+880|880|0)?1(1|3|4|5|6|7|8|9)\d{8}$/', $number) == 1) {

        if (preg_match("/^\+88/", $number) == 1) {
            $number = str_replace('+', '', $number);
        }
        if (preg_match("/^880|^0/", $number) == 0) {
            $number = "880" . $number;
        }
        if (preg_match("/^88/", $number) == 0) {
            $number = "88" . $number;
        }

        return $number;
    } else {
        return false;
    }
}
function send_sms($number,$msg,$type){
    $provider = getSetting('sms_provider');
    if($provider == 'bulk_sms_bd'){
        $status =  bulksmsbd_sms_send($number,$msg);
        addSMSLog($number,$msg,getSetting('bulk_sms_bd_sender_id'),$status,$type);
        return $status;
    }
}
function bulksmsbd_sms_send($phone_number,$msg) {

    $url = "http://bulksmsbd.net/api/smsapi";
    $api_key = getSetting('bulk_sms_bd_api');
    $senderid = getSetting('bulk_sms_bd_sender_id');
    $number = number_validation($phone_number);
    $message = trim($msg);

    $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "number" => $number,
        "message" => $message
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);


    $data = json_decode($response);
    if($data->response_code == 202){
        Notification::make()
            ->title($data->success_message)
            ->success()
            ->send();
        return $data->success_message;
    }else{
        Notification::make()
            ->title($data->error_message)
            ->danger()
            ->send();
        return $data->error_message;
    }
}
function get_balance_bulksmsbd() {
    if(getSetting('bulk_sms_bd_api')){
        $url = "http://bulksmsbd.net/api/getBalanceApi";
        $api_key = getSetting('bulk_sms_bd_api');
        $data = [
            "api_key" => $api_key
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);
        if($data->response_code == 202){
            return $data->balance;
        }else{
            return $data->error_message;
        }
    }
    else{
        return 'Enter api key to know balance';
    }

}
