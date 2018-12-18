<?php

namespace Vlada\AresApi;

class AresRecord
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getICO() {
        return strval($this->data->ICO);
    }

    /**
     * @return string
     */
    public function getDIC() {
        return strval($this->data->DIC);
    }

    /**
     * @return string
     */
    public function getCompanyName() {
        return strval($this->data->OF);
    }

    /**
     * @return AresAddress
     */
    public function getAddress() {
        return new AresAddress($this->data->AA);
    }
}