<?php

namespace Pavelrockjob\Esia\Signers;

abstract class EsiaSigner
{
    abstract public function sign(string $string): string;
}