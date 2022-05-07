<?php

namespace App\Traits;

trait StringTrait
{

    public function splitToArray($text)
    {
        return $text ? explode(':', $text) : [];
    }
}
