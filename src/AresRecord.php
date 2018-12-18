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
        return $this->data->ICO;
    }

    /**
     * @return string
     */
    public function getDIC() {
        return $this->data->DIC;
    }

    /**
     * @return string
     */
    public function getCompanyName() {
        return $this->data->OR;
    }

    /**
     * @return AresAddress
     */
    public function getAddress() {
        return new AresAddress($this->data->AA);
    }
}