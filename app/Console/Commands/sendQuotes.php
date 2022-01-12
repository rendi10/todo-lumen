<?php
namespace App\Console\Commands;

// use App\Models\Orders;
use Illuminate\Console\Command;

class sendQuotes extends command{
  protected $name = 'send-quotes';
  protected $description = "Mengirim kutipan ke telegram";

  public function handle(){
        $data =  $this->getQuote();
        $data = json_decode($data);
        $quote = $data->content;
        $message = urlencode("*QUOTES* \n \n" . $quote);

        $path = "https://api.telegram.org/bot" . env('BOT_TOKEN');
        $chat_id = env('CHAT_ID');

        $url = $path . "/sendmessage?disable_web_page_preview=1&chat_id=" . $chat_id . "&text=" . $message;
        file_get_contents($url);
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
}