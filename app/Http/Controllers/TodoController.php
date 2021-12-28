<?php

namespace App\Http\Controllers;

use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $Todo = Todo::all();

        $res = [
            "message" => "succes, this is ur request",
            "data" => $Todo
        ];

        return response()->json($res, 200);
    }

    public function updateStatus($id){
        $update = Todo::where('id', $id)->update(['status'=> 'true']);
        $todo = Todo::find($id);
    
        //send message to tele
        if($update){
            $path = "https://api.telegram.org/bot" . env('BOT_TOKEN');;
            $chat_id = env('CHAT_ID');
            $msg = "Mangstap, u already done " . $todo->nama;
    
            $url = $path . "/sendmessage?disable_web_page_preview=1&chat_id=" . $chat_id . "&text=" . $msg;
            file_get_contents($url);
        }

        return response()->json($todo, 200);
        
    }
}