<?php

namespace App\Service;

use App\Models\Catalog\Book;

class ThemeService
{
    /**
     * @param Book $book|null
     * @return \Illuminate\Support\Collection
     */
    public function getActiveThemes(Book $book = null)
    {
        $activeThemes = \DB::table('themes')
            ->join('theme_book', 'themes.id', '=', 'theme_book.theme_id')
            ->where('active', 1)
            ->whereRaw('NOW() BETWEEN IFNULL(start_at, "1900-01-01") AND IFNULL(end_at, NOW())');

        if (isset($book)) {
            $activeThemes->where('theme_book.book_id', $book->id);
        }

        return $activeThemes->get();
    }
}
