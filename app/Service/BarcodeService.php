<?php

namespace App\Service;

use App\Models\Catalog\Book;
use App\Models\Catalog\Barcode;

class BarcodeService
{
    /**
     * @var string
     */
    private $barcode;

    /**
     * @var array
     */
    private $usableCodes = [
        // barcode interface
        '{AUTHOR}' => 'author',
        '{SERIES}' => 'series',
        '{PUBLISHER}' => 'publisher',
        '{CATEGORY}' => 'category',
        '{TYPE}' => 'type',

        // custom
        '{BOOK}' => 'book',
        '{ISBN}' => 'isbn',
        '{INCREMENT}' => 'counter',
    ];

    /**
     * At least isbn, book or increment is needed to create unique barcode
     * @var string[]
     */
    private $atleastOneNeeded = [
        '{BOOK}',
        '{ISBN}',
        '{INCREMENT}',
    ];

    /**
     * BarcodeService constructor.
     * @param $barcode
     */
    public function __construct(string $barcode)
    {
        $this->barcode = $barcode;
    }

    /**
     * @return string
     */
    public function generateBarcode(Book $book)
    {
        $newBarcode = $this->barcode;
        $replaced = [];
        $hasIncrementer = false;
        $incrementer = [];
        $matches = $this->validateBarcode();

        $diff = array_diff($this->atleastOneNeeded, $matches);
        if ($diff === 0) {
            throw new \RuntimeException(trans('barcode.not_unique'));
        }

        foreach ($matches as $match) {
            if (!in_array($match, array_keys($this->usableCodes))) {
                throw new \RuntimeException(trans('barcode.no_match', ['match' => $match]));
            }

            $function = $this->usableCodes[$match];

            if ($function === 'book') {
                if (!$book instanceof BarcodeInterface) {
                    throw new \RuntimeException(trans('barcode.implement'));
                }
                $replace = $book->getCode();
            } else if ($function === 'isbn') {
                if ($book->isbn === null) {
                    throw new \RuntimeException(trans('barcode.isbn'));
                }
                $replace = $book->isbn;
            } else if ($function === 'counter') {
                $hasIncrementer = true;
                $replace = count($book->barcodes) + 1;
            } else if (get_class($book->$function) instanceof BarcodeInterface) {
                throw new \RuntimeException(trans('barcode.class_implements', ['class' => get_class($book->$function)]));
            } else {
                $replace = $book->$function->getCode();
            }

            // collect replacements
            $replaced[$match] = $replace;
            // collect to get incrementer only
            if ($function !== 'counter') {
                $incrementer[] = $replace;
            }
        }

        if (count($replaced) !== count($matches)) {
            throw new \RuntimeException(trans('barcode.not_correct'));
        }
        $result = str_replace(array_keys($replaced), array_values($replaced), $newBarcode);

        // check if current incrementer must be higher
        if ($hasIncrementer) {
            // replace all to get the incrementer
            $currentIncrementer = (int) str_replace($incrementer, '', $newBarcode);

            // get barcode without increment so we can check for existing increments
            // TODO this only work when increment is at the end!
            // TODO we should create better check for incrementer
            $barcodeChecker = $replaced;
            $barcodeChecker['{INCREMENT}'] = '';
            $barcodeWithoutIncrementer = str_replace(array_keys($barcodeChecker), array_values($barcodeChecker), $newBarcode);
            $foundBarcodes = Barcode::where('barcode', 'LIKE', $barcodeWithoutIncrementer . '%')->orderBy('id', 'DESC')->get();

            // check new incrementer must be higher
            $newIncrementer = $currentIncrementer;
            foreach ($foundBarcodes as $foundBarcode) {
                $foundIncrementer = (int) str_replace($barcodeWithoutIncrementer, '', $foundBarcode);
                if ($foundIncrementer > $newIncrementer) {
                    $newIncrementer = $foundIncrementer;
                }
            }

            $replaced['{INCREMENT}'] = $newIncrementer + 1;
            $result = str_replace(array_keys($replaced), array_values($replaced), $newBarcode);
        }

        return $result;
    }

    public function validateBarcode()
    {
        preg_match_all('/\{([^}]+)\}/', $this->barcode, $matches);

        if (count($matches[0]) === 0) {
            throw new \RuntimeException(trans('barcode.invalid'));
        }

        return $matches[0];
    }
}
