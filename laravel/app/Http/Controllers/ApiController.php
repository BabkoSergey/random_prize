<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiController {

    private $api_url;
    private $merchant_url;
    private $merchant_key;
    private $merchant_account;

    public function __construct() {
        $this->api_url = env('BANKING_HOST');
        $this->merchant_key = env('BANKING_SECRET');
        $this->mercahnt_url = env('APP_URL');        
        $this->merchant_account = env('BANKING_ACCOUNT');        
    }

    /**
     * Call to Banking API
     *
     * @param string $type GET, POST, ...
     * @param string $url Enpoint
     * @param array $params
     * @return json Request params
     */
    public function callBanking($params = [], $url = '', $type = 'POST') {
        $client = new Client();

        $request_options = [];
        $request_options['headers'] = [
            'Authorization' => 'Bearer ' . $this->merchant_key,
            'Operator-Name' => $this->mercahnt_url,
        ];

        $response = [];
        if (!empty($params)) {
            $params['from'] = $this->merchant_account;
            $request_options['json'] = $params;
        }else{
            $response['error'] = 'Empty request!';
            return $response;
        }

        try {
            $res = $client->request($type, $this->api_url . '/api/' . $url, $request_options);
            $body = $res->getBody();
            $response['success'] = json_decode($body);
        } catch (RequestException $e) {
            $response['error'] = 'Catch error';
            if ($e->hasResponse()) {
                $body = $e->getResponse()->getBody();
                $response['error'] = json_decode($body);
            }
        }

        return $response;
    }

}
