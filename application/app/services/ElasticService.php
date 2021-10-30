<?php

class ElasticService
{

    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    //'query' => [
        //'match' => [
            //'name' => "$searchTerm"
        //]
    //]
    //'query' => [
        //'query_string' => [
            //'query' => $searchTerm,
            //'fields' => [
                //'name', 'email'
            //]
        //]
    //]
    public function search($data)
    {
        return $this->curl('_search', 'GET', $data);
    }


    //'index' => 'phalcon',
    //'type' => 'document',
    //'body' => [
    //    'id' => $user['id'],
    //    'name' => $user['name'],
    //    'email' => $user['email'],
    //]
    public function put($data)
    {
        $uri = $data['index'] . '/' . $data['type'];

        return $this->curl($uri, 'POST', $data);
    }

    private function curl($uri, $method = 'GET', $data = [])
    {
        $endpoint = 'http://elasticsearch:9200/' . ltrim($uri, '/');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data['body']),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return curl_error($curl);
        }

        curl_close($curl);
        return json_decode($response, 1);
        echo '<pre>', print_r($response, true), '</pre>';die;

    }
}