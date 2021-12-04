<?php

namespace App\Service;

interface BarcodeInterface
{
    /**
     * @return string|null
     */
    public function getCode();
}