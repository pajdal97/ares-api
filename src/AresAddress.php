<?php

namespace Vlada\AresApi;

class AresAddress
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Stát
     * @return string
     */
    public function getCountry() {
        return $this->data->NS;
    }

    /**
     * Mezinárodní identifikátor
     * @return string
     */
    public function getCountryID() {
        return $this->data->KS;
    }

    /**
     * Město
     * @return string
     */
    public function getCity() {
        return $this->data->N . (!empty($this->data->NCO) ? ' - ' . $this->data->NCO : '');
    }

    /**
     * Název ulice
     * @return string
     */
    public function getStreetName() {
        return $this->data->NU;
    }

    /**
     * číslo popisné / číslo orientační
     * @return string
     */
    public function getStreetNumber() {
        return $this->data->CD . '/' . $this->data->CO;
    }

    /** Celný název ulice
     * @return string
     */
    public function getStreet() {
        return $this->getStreetName() . ' ' . $this->getStreetNumber();
    }

    /**
     * PSČ
     * @return string
     */
    public function getZIP() {
        return $this->data->PSC;
    }
}