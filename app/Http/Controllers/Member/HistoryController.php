<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Administration\Member;
use App\Models\Catalog\Author;

class HistoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Member $member)
    {
        $history = $member->lended(true)->collect(['lend_at' => 'desc']);
        $authors = Author::enabled()->get()->pluck('name', 'id');

        return view('member.history.index', compact('member', 'history', 'authors'));
    }
}
