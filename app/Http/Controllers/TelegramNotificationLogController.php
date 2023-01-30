<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TelegramNotificationLog;
use App\User;
use App\Jobs\FailTest;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Auth;

class TelegramNotificationLogController extends Controller
{
    //

    public static function telegramNotifySuperUsers($message)
    {
        $supers = User::where('role_id', 1)->get();
        if (!$supers) {
            return;
        }

        foreach ($supers as $super) {
            if ($super->telegram_chat_id) {
                $notification = "Mensaje para super usuarios: " . $message;
                TelegramNotificationLog::sendNotification($super->telegram_chat_id, $notification);
            }
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
                $notification = $message;
                TelegramNotificationLog::sendNotification($admin->telegram_chat_id, $notification);
            }
        }
    }

    public function testJob(){
        Queue::push(new FailTest());
    }

    public function handle(Request $request)
    {
        $json = json_encode($request->message);
        $raw = $request->message;
        $chat_id=null;
        $user_token=null;
        $message=null;
        $update_id = $request->update_id;

        

        if(isset($raw['from'])){
            if(isset($raw['from']['id'])){
                $chat_id = $raw['from']['id'];
            }
        }

        if(isset($raw['text'])){
            $message = $raw['text'];
            $user_token = trim( str_replace('/start ','',$message) );
        }

        $new = TelegramNotificationLog::create([
            'message' => $message,
            'update_id' => $update_id,
            'json_data'  => $json,
            'chat_id' => $chat_id,
            'user_token'=>$user_token    
        ]);


        if($user_token && $chat_id)
        {
            $user = User::where('reg_verif_code',$user_token)->get()->first();
            if(!$user){return;}
            $user->telegram_chat_id = $chat_id ;
            $user->save();
            $greeting = "Hola!. Ya estas suscrit@ a las notificaciones de suspensionlujan.com." ;
            TelegramNotificationLog::sendNotification($user->telegram_chat_id,$greeting);
        }else{
           return $json;
        }

       // return $new;
    }
}
