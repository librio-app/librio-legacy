<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Catalog\Author;
use App\Models\Catalog\Book;
use App\Models\Catalog\Category;
use App\Models\Catalog\Publisher;
use App\Models\Catalog\Series;
use App\Models\Catalog\Type;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CatalogController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoriesCodes(Request $request)
    {
        $code = $request->getContent();
        $duplicated = false;

        $categories = Category::withoutGlobalScope(SoftDeletingScope::class)->where('code',  '=', $code)->get();

        if ($categories->count() > 0) {
            $duplicated = true;
        };

        return response()->json([
            'duplicated' => $duplicated,
            'code' => $code,
            'message' => trans('validation.unique', ['attribute' => $code]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authorsCodes(Request $request)
    {
        $code = $request->getContent();
        $duplicated = false;

        $authors = Author::withoutGlobalScope(SoftDeletingScope::class)->where('code',  '=', $code)->get();

        if ($authors->count() > 0) {
            $duplicated = true;
        };

        return response()->json([
            'duplicated' => $duplicated,
            'code' => $code,
            'message' => trans('validation.unique', ['attribute' => $code]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishersCodes(Request $request)
    {
        $code = $request->getContent();
        $duplicated = false;

        $publishers = Publisher::withoutGlobalScope(SoftDeletingScope::class)->where('code',  '=', $code)->get();

        if ($publishers->count() > 0) {
            $duplicated = true;
        };

        return response()->json([
            'duplicated' => $duplicated,
            'code' => $code,
            'message' => trans('validation.unique', ['attribute' => $code]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function booksCodes(Request $request)
    {
        $code = $request->getContent();
        $duplicated = false;

        $books = Book::withoutGlobalScope(SoftDeletingScope::class)->where('code',  '=', $code)->get();

        if ($books->count() > 0) {
            $duplicated = true;
        };

        return response()->json([
            'duplicated' => $duplicated,
            'code' => $code,
            'message' => trans('validation.unique', ['attribute' => $code]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function seriesCodes(Request $request)
    {
        $code = $request->getContent();
        $duplicated = false;

        $series = Series::withoutGlobalScope(SoftDeletingScope::class)->where('code',  '=', $code)->get();

        if ($series->count() > 0) {
            $duplicated = true;
        };

        return response()->json([
            'duplicated' => $duplicated,
            'code' => $code,
            'message' => trans('validation.unique', ['attribute' => $code]),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function typesCodes(Request $request)
    {
        $code = $request->getContent();
        $duplicated = false;

        $series = Type::withoutGlobalScope(SoftDeletingScope::class)->where('code',  '=', $code)->get();

        if ($series->count() > 0) {
            $duplicated = true;
        };

        return response()->json([
            'duplicated' => $duplicated,
            'code' => $code,
            'message' => trans('validation.unique', ['attribute' => $code]),
        ]);
    }
}