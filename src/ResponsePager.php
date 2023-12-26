<?php

namespace Wicket;

class ResponsePager
{
    public $client;

    protected $next_page_callback;


    public function __construct($client, $response, $fetch_page_callback = null)
    {
        $this->client = $client;
        $this->setResponse($response);
        $this->fetch_page_callback = null;
    }


    protected function setResponse($response)
    {
        $this->response = $response;

        if ($response) {
            $this->responseHelper = new ResponseHelper($response);
        } else {
            $this->responseHelper = null;
        }
    }


    public function response()
    {
        return $this->response;
    }


    public function responseHelper()
    {
        return $this->responseHelper;
    }


    public function eachPage($callback)
    {
        while ($this->hasData() || $this->hasNextPage()) {
            call_user_func_array($callback, [$this]);
            $this->fetchNextPage();
        }
    }


    public function hasData()
    {
        return ! empty($this->response['data']);
    }


    public function hasNextPage($response = null)
    {
        if ($response == null) {
            $response = $this->response;
        }

        return ! empty($response['links']['next']);
    }


    public function fetchNextPage()
    {
        if ($this->hasNextPage()) {
            $next_response = $this->fetch($this->response['links']['next']);
            $this->setResponse($next_response);
        } else {
            $this->setResponse(null);
        }
    }


    protected function fetch($page_url)
    {
        if ($this->fetch_page_callback) {
            return call_user_func_array($this->next_page_callback, [$page_url, $this]);
        } else {
            return $this->client->get($page_url);
        }
    }


    public function fetchPrevPage()
    {
        if ($this->hasPrevPage()) {
            $prev_response = $this->fetch($this->response['links']['prev']);
            $this->setResponse($prev_response);
        } else {
            $this->setResponse(null);
        }
    }


    public function hasPrevPage($response = null)
    {
        if ($response == null) {
            $response = $this->response;
        }

        return ! empty($response['links']['prev']);
    }
}
