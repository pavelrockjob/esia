<?php

namespace Pavelrockjob\Esia\Signers;

class CustomSigner extends EsiaSigner
{

    public function sign(string $string): string
    {
        //Нужно что то сделать что бы сформировать строку в ГОСТ Р 34.11-2012
        return  $string;
    }
}