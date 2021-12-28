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

        // if($res){
        //     json_decode(file_get_contents(
        //         'http://todo-app-lumen.local/done/6'), true);
        // }
        
    }

    public function getQuote()
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://quotes15.p.rapidapi.com/quotes/random/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: quotes15.p.rapidapi.com",
                "x-rapidapi-key: 13bb84b628msh55a32317ca324b3p1fd8c0jsn2b305dfebe47"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }

    }

    public function sendQuote(){
        $data =  $this->getQuote();
        $data = json_decode($data);
        $quote = $data->content;

        $path = "https://api.telegram.org/bot" . env('BOT_TOKEN');;
	    $chat_id = env('CHAT_ID');

        $url = $path . "/sendmessage?disable_web_page_preview=1&chat_id=" . $chat_id . "&text=" . $quote;
	    file_get_contents($url);
    }
}