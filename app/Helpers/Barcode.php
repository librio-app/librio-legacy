<?php

namespace App\Helpers;

class Barcode
{
    /**
     * @param string $status
     * @return string|void
     */
    public static function getLabel(string $status)
    {
        switch ($status) {
            case 'new';
            case 'in_reservation';
                return 'primary';
            case 'in_repair';
                return 'warning';
            case 'lost';
            case 'lended';
            case 'deleted';
                return 'danger';
            case 'taken_in'; // not used yet?
                return 'warning';
            case 'available';
                return 'success';
        }

        return '';
    }
}
