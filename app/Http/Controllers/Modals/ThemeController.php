<?php

namespace App\Http\Controllers\Modals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Theme as Request;
use App\Models\Catalog\Theme;

class ThemeController extends Controller
{
    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create()
    {
        $html = view('modals.theme.create')->render();

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => 'null',
            'html' => $html,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $series = Theme::create($request->all());

        $message = trans('messages.success.added', ['type' => trans_choice('general.theme', 1)]);

        return response()->json([
            'success' => true,
            'error' => false,
            'data' => $series,
            'message' => $message,
            'html' => null,
        ]);
    }
}
