<?php
/**
 * Created by PhpStorm.
 * User: khaledkhamis
 * Date: 4/19/16
 * Time: 4:20 PM
 */

namespace Khaledkhamis\Teleduino;

use \GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Config;
use League\Flysystem\Exception;

class Teleduino
{
    protected $key;
    protected $client;
    protected $response;
    protected $api='328';
    /**
     * Teleduino constructor.
     * @param $key
     * @param $api
     */
    public function __construct($api='328')
    {
        $this->api=$api;
        $this->key = config('teleduino.key');
        $this->client = new Client([
            'base_uri' => 'https://us01.proxy.teleduino.org/api/1.0/'.$this->api.'.php',
            'timeout' => 20.0,
        ]);
        echo $this->key;
    }

    /**
     * @param $function
     * @param $fields
     * @return TeleduinoResponse
     */
    public function sendRequest($function, $fields)
    {
        try {
            $parameters = ['r' => $function, 'k' => $this->key];
            $query = array_merge($parameters, $fields);
            $query = ['query' => $query];
            $response = $this->client->request('GET', '', $query);
            $this->response = json_decode($response->getBody());
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $this->response = json_decode($e->getResponse()->getBody());
            }
        }
        return new TeleduinoResponse($this->response);
    }

    /**
     * @param $pin 0-1
     * @param $mode 10-20
     * @return TeleduinoResponse
     */
    public function definePinMode($pin, $mode)
    {
        return $this->sendRequest(__FUNCTION__, ['pin' => $pin, 'mode' => $mode]);
    }

    /**
     * @param $pin
     * @param $output
     * @return TeleduinoResponse
     */
    public function setDigitalOutput($pin, $output)
    {
        return $this->sendRequest(__FUNCTION__, ['pin' => $pin, 'output' => $output]);
    }

    /**
     * @param $pin
     * @param $output
     * @return TeleduinoResponse
     */
    public function setPwmOutput($pin, $output)
    {
        return $this->sendRequest(__FUNCTION__, ['pin' => $pin, 'output' => $output]);
    }

    /**
     * @param $pin
     * @return TeleduinoResponse
     */
    public function getDigitalInput($pin)
    {
        return $this->sendRequest(__FUNCTION__, ['pin' => $pin]);
    }

    /**
     * @param $pin
     * @return TeleduinoResponse
     */
    public function getAnalogInput($pin)
    {
        return $this->sendRequest(__FUNCTION__, ['pin' => $pin]);

    }

    /**
     * @return TeleduinoResponse
     */
    public function getAllInputs()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @return TeleduinoResponse
     */
    public function reset()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @return TeleduinoResponse
     */
    public function getVersion()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @param $pin
     * @return TeleduinoResponse
     */
    public function setStatusLedPin($pin)
    {
        return $this->sendRequest(__FUNCTION__, ['pin' => $pin]);
    }

    /**
     * @param $outputs
     * @param bool|false $expireTimes
     * @param bool|false $offset
     * @return TeleduinoResponse
     */
    public function setDigitalOutputs($outputs, $expireTimes = false, $offset = false)
    {
        return $this->sendRequest(__FUNCTION__, ['outputs' => $outputs, 'expireTimes' => $expireTimes, 'offset' => $offset]);
    }

    /**
     * @param $count
     * @return TeleduinoResponse
     */
    public function setStatusLed($count)
    {
        return $this->sendRequest(__FUNCTION__, ['count' => $count]);
    }

    /**
     * @return TeleduinoResponse
     */
    public function getFreeMemory()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @return TeleduinoResponse
     */
    public function ping()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @return TeleduinoResponse
     */
    public function getUpTime()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @return TeleduinoResponse
     */
    public function loadPresets()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @param $shiftRegister
     * @param $clockPin
     * @param $dataPin
     * @param $latchPin
     * @param $enablePin
     * @return TeleduinoResponse
     */
    public function defineShiftRegister($shiftRegister, $clockPin, $dataPin, $latchPin, $enablePin)
    {
        return $this->sendRequest(__FUNCTION__, ['shift_register'=>$shiftRegister,'clock_pin'=>$clockPin,'data_pin'=>$dataPin,'latch_pin'=>$latchPin,'enable_pin'=>$enablePin]);
    }

    /**
     * @param $shiftRegister
     * @param $outputs
     * @return TeleduinoResponse
     */
    public function setShiftRegister($shiftRegister, $outputs)
    {
        return $this->sendRequest(__FUNCTION__, ['shift_register'=>$shiftRegister,'outputs'=>$outputs]);
    }

    /**
     * @param $shiftRegister
     * @param $action
     * @param $expireTime
     * @param $outputs
     * @return TeleduinoResponse
     */
    public function mergeShiftRegister($shiftRegister, $action, $expireTime, $outputs)
    {
        return $this->sendRequest(__FUNCTION__, ['shift_register'=>$shiftRegister,'action'=>$action,'expire_time'=>$expireTime,'outputs'=>$outputs]);
    }

    /**
     * @param $shiftRegister
     * @return TeleduinoResponse
     */
    public function getShiftRegister($shiftRegister)
    {
        return $this->sendRequest(__FUNCTION__, ['shift_register'=>$shiftRegister]);
    }

    /**
     * @param int $port
     * @param int $baud
     * @return TeleduinoResponse
     */
    public function defineSerial($port=0, $baud=9600)
    {
        return $this->sendRequest(__FUNCTION__, ['port'=>$port,'baud'=>$baud]);
    }

    /**
     * @param int $port
     * @param $bytes
     * @return TeleduinoResponse
     */
    public function setSerial($port=0, $bytes)
    {
        return $this->sendRequest(__FUNCTION__, ['port'=>$port,'bytes'=>$bytes]);
    }

    /**
     * @param int $port
     * @param $byteCount
     * @return TeleduinoResponse
     */
    public function getSerial($port=0, $byteCount)
    {
        return $this->sendRequest(__FUNCTION__, ['port'=>$port,'byte_count'=>$byteCount]);
    }

    /**
     * @param int $port
     * @return TeleduinoResponse
     */
    public function flushSerial($port=0)
    {
        return $this->sendRequest(__FUNCTION__, ['port'=>$port]);
    }
    /**
     * @param $servo
     * @param $pin
     * @return TeleduinoResponse
     */
    public function defineServo($servo, $pin)
    {
        return $this->sendRequest(__FUNCTION__, ['servo'=>$servo,'pin'=>$pin]);
    }
    /**
     * @param $servo
     * @param $position
     * @return TeleduinoResponse
     */
    public function setServo($servo, $position)
    {
        return $this->sendRequest(__FUNCTION__, ['servo'=>$servo,'position'=>$position]);
    }

    /**
     * @return TeleduinoResponse
     */
    public function resetEeprom()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @param $offset
     * @param $bytes
     * @return TeleduinoResponse
     */
    public function setEeprom($offset, $bytes)
    {
        return $this->sendRequest(__FUNCTION__, ['offset'=>$offset,'bytes'=>$bytes]);

    }

    /**
     * @param $offset
     * @param $byteCount
     * @return TeleduinoResponse
     */
    public function getEeprom($offset, $byteCount)
    {
        return $this->sendRequest(__FUNCTION__, ['offset'=>$offset,'byte_count'=>$byteCount]);
    }

    /**
     * @return TeleduinoResponse
     */
    public function defineWire()
    {
        return $this->sendRequest(__FUNCTION__, []);
    }

    /**
     * @param $address
     * @param $byte
     * @return TeleduinoResponse
     */
    public function setWire($address, $byte)
    {
        return $this->sendRequest(__FUNCTION__, ['address'=>$address,'byte'=>$byte]);
    }

    /**
     * @param $address
     * @param $byteCount
     * @return TeleduinoResponse
     */
    public function getWire($address, $byteCount)
    {
        return $this->sendRequest(__FUNCTION__, ['address'=>$address,'byte_count'=>$byteCount]);
    }
}