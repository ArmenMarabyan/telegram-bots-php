<?php


class TelegramService
{
    /**
     * @var string
     * Todo from env
     */
    protected $token = '2074761169:AAGXwmW1pKxVhbPfUZM7Y56M4inNZFHZkZQ';

    protected $endpoint = 'https://api.telegram.org/bot';

    /**
     * @param $string
     * @return string
     */
    public function cirStrrev($string)
    {
        preg_match_all('/./us', $string, $array);

        return implode('',array_reverse($array[0]));
    }

    /**
     * @param $chatId
     * @param $message
     * @return bool|string
     */
    public function sendMessage($chatId, $message)
    {
        $endpoint = $this->endpoint . $this->token;

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        $result = $this->curl($endpoint, 'POST', $data, 'sendMessage');

        return $result;
    }

//    public function request($method, $data = array())
//    {
//        $curl = curl_init();
//
//        curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $this->token . '/' . $method);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
//        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//
//        $out = json_decode(curl_exec($curl), true);
//
//        curl_close($curl);
//
//        return $out;
//    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @param string $type
     */
    public function curl(string $endpoint, string $method = 'GET', array $data = [], string $type = 'sendMessage')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint . '/' . $type,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

}