<?php

namespace App\Http\Controllers;

use App\Models\Todo;


class TeleController extends Controller
{
    //bot token
    protected $token = "5023312731:AAGsYkKz0I39bOnE_kb43AE2k68NlJHXkaY";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function sendButton(){
        $todo = Todo::where('status', 'false')->get();
    
        // Create data
        $data = http_build_query([
            'text' => 'list of activity you should done todayyyy!!!!!!',
            'chat_id' => '714779698'
        ]);

        // Create keyboard
        $keyboard = json_encode([
            "inline_keyboard" => []
        ]);

        //dekode
        $keyboardDecode = json_decode($keyboard);
        //get data from database
        foreach ($todo as $row){
            array_push($keyboardDecode->inline_keyboard,[[
                "text" => $row['nama'],
                "callback_data" => $row['id'],
                // "url" => "todo-app-lumen.local/done/" . $row['id']
            ]]);
        }
        //enkode
        $keyboard = json_encode($keyboardDecode);


        // Send keyboard
        $token = env('BOT_TOKEN');
        $url = "https://api.telegram.org/bot$token/sendMessage?{$data}&reply_markup={$keyboard}";
        $res = @file_get_contents($url);
        if (isset($update['callback_query'])) {
            $path = "https://api.telegram.org/bot" . env('BOT_TOKEN');;
            $chat_id = env('CHAT_ID');
            $msg = "Mangstap, u already done " . $update['callback_query'];
    
            $url = $path . "/sendmessage?disable_web_page_preview=1&chat_id=" . $chat_id . "&text=" . $msg;
            file_get_contents($url);
        }        
    }    
}