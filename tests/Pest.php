<?php

use RicorocksDigitalAgency\Soap\Contracts\Soapable;
use RicorocksDigitalAgency\Soap\Parameters\IntelligentBuilder;
use RicorocksDigitalAgency\Soap\Response\Response;
use RicorocksDigitalAgency\Soap\Soap;
use RicorocksDigitalAgency\Soap\Support\Fakery\Fakery;
use RicorocksDigitalAgency\Soap\Support\Fakery\Stubs;

include __DIR__ . '/../src/helpers.php';

const EXAMPLE_SOAP_ENDPOINT = 'http://www.dneonline.com/calculator.asmx?WSDL';

function soap(?Fakery $fakery = null, ?\RicorocksDigitalAgency\Soap\Request\Request $request = null) {
    return new Soap(
        $fakery ?? new Fakery(new Stubs()),
        $request ?? new RicorocksDigitalAgency\Soap\Request\SoapClientRequest(new IntelligentBuilder())
    );
}

function fakeRequest(int $result, ?Soap $soap = null) {
    ($soap ?? soap())->fake(['*' => Response::new(['AddResult' => $result])]);
}

class ExampleSoapable implements Soapable
{
    public function toSoap()
    {
        return [
            'intA' => 10,
            'intB' => 25,
            'foo' => soap()->node(['email' => 'hi@me.com'])->body(['bar' => soap()->node()->body(['hello' => 'world'])]),
            'bar' => ['baz', 'bang'],
        ];
    }
}
