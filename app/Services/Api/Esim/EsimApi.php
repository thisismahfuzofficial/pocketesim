<?php

namespace App\Services\Api\Esim;

use Illuminate\Support\Facades\Http;

class EsimApi
{

    protected $api;
    protected $method = 'GET';
    protected $body = [];
    protected $headers = [];



    public function setApi(string $api)
    {
        $this->api = $api;
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    public function setBody(array $body)
    {
        $this->body = $body;
    }   
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }


    public function send()
    {
        switch ($this->method) {
            case 'GET':
                return Http::withHeaders($this->headers)->get($this->api, $this->body)->json();
            case 'POST':
                return Http::withHeaders($this->headers)->post($this->api, $this->body)->json();
            case 'PUT':
                return Http::withHeaders($this->headers)->put($this->api, $this->body)->json();
            case 'DELETE':
                return Http::withHeaders($this->headers)->delete($this->api, $this->body)->json();
        }
    }
}
