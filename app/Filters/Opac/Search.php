<?php

namespace App\Filters\Opac;

use EloquentFilter\ModelFilter;

class Search extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($query)
    {
        return $this->where(function($q) use ($query)
        {
            return $q->where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%')
                ->orWhere('isbn', 'LIKE', '%' . $query . '%')
                ->orWhere('code', 'LIKE', '%' . $query . '%');
        });
    }

    public function barcode($barcode)
    {
        return $this->related('barcodes', 'barcode', (string) $barcode);
    }

    public function author($author)
    {
        return $this->related('author', 'id', (int) $author);
    }

    public function category($category)
    {
        return $this->related('category', 'id', (int) $category);
    }

    public function lended($bool)
    {
        if (isset($bool)) {
            if ((bool) $bool) {
                return $this->related('barcodes', 'status', 'lended');
            } else {
                return $this->related('barcodes', 'status', '!=', 'lended');
            }
        }

        return $this;
    }

    public function serie($serie)
    {
        return $this->where('series_id', '=', $serie);
    }

    public function series($bool)
    {
        if (isset($bool)) {
            if ((bool) $bool) {
                return $this->whereNotNull('series_id');
            } else {
                return $this->whereNull('series_id');
            }
        }

        return $this;
    }

    public function themes($themes)
    {
        if (is_array($themes)) {
            return $this->related('themes', 'id', (array) $themes);
        }

        return $this;
    }
}
