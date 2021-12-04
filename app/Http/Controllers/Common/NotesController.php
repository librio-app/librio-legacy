<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Note as Request;
use App\Models\Common\Note;

class NotesController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        return redirect()->route('dashboard');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $note = Note::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.notes', 1)]);

        flash($message)->success();

        return redirect()->route('dashboard');
    }

    /**
     * @param Note $note
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('dashboard');
    }
}