<?php

namespace Vlada\AresApi;

class Ares
{
    const BASE_URL = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi?ico=';

    private $ic;

    public function __construct($ic)
    {
        $this->ic = $ic;
    }

    /**
     * @return bool|string
     */
    private function sendRequest()
    {
        return @file_get_contents(self::BASE_URL . $this->ic);
    }

    /**
     * @return \SimpleXMLElement
     * @throws AresNotFoundException
     * @throws InvalidIcoException
     */
    private function getData()
    {
        if (self::verify($this->ic)) {
            throw new InvalidIcoException('Neplatné IČO');
        }
        $xml = @simplexml_load_string($this->sendRequest());

        $ns = $xml->getDocNamespaces();
        $data = $xml->children($ns['are']);
        $el = $data->children($ns['D'])->VBAS;

        if (strval($el->ICO) != $this->ic) {
            throw new AresNotFoundException();
        }

        return $el;
    }

    /**
     * @return AresRecord
     * @throws AresNotFoundException
     * @throws InvalidIcoException
     */
    public function getRecord()
    {
        return new AresRecord($this->getData());
    }

    /**
     * @param string $ic
     * @return bool
     */
    public static function verify($ic)
    {
        $ic = preg_replace('#\s+#', '', $ic);

        if (!preg_match('#^\d{8}$#', $ic)) {
            return false;
        }

        $a = 0;
        for ($i = 0; $i < 7; $i++) {
            $a += $ic[$i] * (8 - $i);
        }

        $a = $a % 11;
        if ($a === 0) {
            $c = 1;
        } elseif ($a === 1) {
            $c = 0;
        } else {
            $c = 11 - $a;
        }

        return (int)$ic[7] === $c;
    }
}