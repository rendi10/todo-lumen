<?php
namespace App\Console\Commands;

// use App\Models\Orders;
use Illuminate\Console\Command;

class sendFixtures extends command{
  protected $name = 'send-fixtures';
  protected $description = "Mengirim jadwal Real Madrid ke telegram";

  public function handle(){
        $data =  $this->getFixtures();
        $data = json_decode($data);
        // $fixture = $data->fixture;
        $date = $data->response[0]->fixture->date;
        $tanggal = substr($date, 0, 10);
        $jam = substr($date, 11, 5);
        $competition = $data->response[0]->league->name;
        $home = $data->response[0]->teams->home->name;
        $away = $data->response[0]->teams->away->name;

        $message = urlencode("Next Jadwal Madrid \n\n" . "Tanggal " . $tanggal . "\n" . "Jam " . $jam  . " WIB" . "\n" . $competition . "\n" . $home . " VS " . $away);

        $path = "https://api.telegram.org/bot" . env('BOT_TOKEN');
        $chat_id = env('CHAT_ID');

        $url = $path . "/sendmessage?disable_web_page_preview=1&chat_id=" . $chat_id . "&text=" . $message;
        file_get_contents($url);
  }

  public function getFixtures(){
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-football-beta.p.rapidapi.com/fixtures?next=1&team=541&timezone=Asia%2FBangkok",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: api-football-beta.p.rapidapi.com",
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