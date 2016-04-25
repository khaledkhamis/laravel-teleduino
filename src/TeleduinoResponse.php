<?php
/**
 * Created by PhpStorm.
 * User: khaledkhamis
 * Date: 4/25/16
 * Time: 8:21 PM
 */

namespace Khaledkhamis\Teleduino;


class TeleduinoResponse
{
    protected $response;
    protected $status;
    protected $message;
    protected $responseBody;

    public function __construct($response)
    {
        $this->responseBody = $response;
        $this->status = $response->status;
        $this->message = $response->message;
        $this->response = $response->response;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResult()
    {
        return isset($this->response['result']) ? $this->response['result'] : 0;
    }

    public function isSuccess()
    {
        return $this->getResult();
    }

    public function getRequestTime()
    {
        return isset($this->response['time']) ? $this->response['time'] : 0;
    }

    public function hasValues()
    {
        return isset($this->response['values']) && count($this->response['values']) > 0;
    }

    public function getValues()
    {
        return $this->hasValues() ? $this->response['values'] : null;
    }

    public function getValue()
    {
        return $this->hasValues() ? $this->getValues()[0] : null;
    }
}