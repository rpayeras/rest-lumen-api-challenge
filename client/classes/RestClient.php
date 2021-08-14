<?php

class RestClient{
    private string $url;
    private string $token;

    public function __construct(string $url){
        $this->url = $url;
    }

    function get($uri, $id = null) {
//        echo "Getting get with uri $uri...";

        $headers = [
            'Content-Type: multipart/form-data',
        ];

        if(!empty($this->token)){
            $headers[] = "Authorization: Bearer $this->token";
        }

        if(!empty($id)){
            $uri .= "/".$id;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$uri);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false); // this is important for you I think
        curl_setopt($ch, CURLOPT_FAILONERROR, false); // this is important for you I think

        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if (!$response) {
            $response['url'] = $this->url.$uri;
            $curlError = curl_error($ch);
            $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response['errors'] = $curlError;
            $response['code'] = $httpCode;

            if($response === false) {
                throw new RuntimeException('curl fail');
            }
        }

        curl_close($ch);

        return $response;
    }

    public function post($uri, $data) {
        $payload = $data;

        $headers = [
            'Content-Type: multipart/form-data',
        ];

        if(!empty($this->token)){
            $headers[] = "Authorization: Bearer $this->token";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$uri);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false); // this is important for you I think

        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if (!$response) {
            $curlError = curl_error($ch);
            $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $response = json_decode($response, true);
            $response['url'] = $this->url.$uri;
            $response['params'] = $payload;
            $response['code'] = $httpCode;
            $response['errors'] = $curlError;

            if($response === false) {
                throw new RuntimeException('curl fail');
            }
        }

        curl_close($ch);

        return $response;
    }

    public function login($username, $password) {
        $payload = [
            'username' => $username,
            'password' => $password
        ];

        $response = $this->post('/auth/login', $payload);
        if (!isset($response['access_token']) || ! isset($response['token_type'])) {
            return $response;
        }

        $this->token = $response['access_token'];

//        echo "token received";
//        echo $this->token;

        return $response;
    }
}
