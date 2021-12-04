<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Catalog\Type;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Type as Request;

class TypesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $types = Type::collect();

        return view('catalog.types.index', compact('types'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('catalog.types.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $type = Type::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.types', 1)]);

        flash($message)->success();

        return redirect('catalog/types');
    }

    /**
     * @param Type $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Type $type)
    {
        return view('catalog.types.edit', compact('type'));
    }

    /**
     * @param Type $type
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Type $type, Request $request)
    {
        // Update category
        $type->update($request->input());

        $message = trans('messages.success.updated', ['type' => trans_choice('general.types', 1)]);

        flash($message)->success();

        return redirect('catalog/types');
    }

    /**
     * @param Type $type
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Type $type)
    {
        if ($type->books()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.types', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);

            flash($message)->error();
        } else {
            $type->delete();
        }

        return redirect()->route('types.index');
    }
}
