<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp;
use App\User;

class TelegramNotificationLog extends Model
{
    //
    protected $guarded = [];
    
    public static function sendNotification($chat_id,$message){
        $telegram_bot_name = 'suspensionlujan_bot' ;
        $bot_token = ENV('TELEGRAM_BOT_TOKEN');
        $message = $message.' __ - Este es un mensaje automático, por favor no responder. - __ ';
        $text = urlencode($message);
        if(!$bot_token){return;}
        $url = "https://api.telegram.org/bot{$bot_token}/sendMessage?chat_id={$chat_id}&text={$text}" ;
        
        $client = new GuzzleHttp\Client();
        try {
            $response = $client->get($url);
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function telegramNotifyAdmins($message)
    {
        $admins = User::where('role_id','<=', 2)->get();
        if (!$admins) {
            return;
        }
        foreach ($admins as $admin) {
            if ($admin->telegram_chat_id) {
                static::sendNotification($admin->telegram_chat_id, $message);
            }
        }
    }
    public static function telegramNotifySupers($message)
    {
        $supers = User::where('role_id', 1)->get();
        if (!$supers) {
            return;
        }
        foreach ($supers as $super) {
            if ($super->telegram_chat_id) {
                static::sendNotification($super->telegram_chat_id, $message);
            }
        }
    }
}
