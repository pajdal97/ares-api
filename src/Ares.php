<?php

namespace Vlada\AresApi;

class Ares
{
    const BASE_URL = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=';

    private $ico;

    public function __construct($ico)
    {
        $this->ico = $ico;
    }

    /**
     * @return bool|string
     */
    private function sendRequest()
    {
        return @file_get_contents(self::BASE_URL . $this->ico);
    }

    /**
     * @return \SimpleXMLElement
     * @throws AresNotFoundException
     */
    private function getData()
    {
        $xml = @simplexml_load_string($this->sendRequest());

        $ns = $xml->getDocNamespaces();
        $data = $xml->children($ns['are']);
        $el = $data->children($ns['D'])->VBAS;

        if (strval($el->ICO) != $el->ICO) {
            throw new AresNotFoundException();
        }

        return $el;
    }

    /**
     * @return AresRecord
     * @throws AresNotFoundException
     */
    public function getRecord()
    {
        return new AresRecord($this->getData());
    }

}