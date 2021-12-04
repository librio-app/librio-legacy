<?php


namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chart\Lended as Request;

class BooksController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function books(Request $request)
    {
        $year = date('Y');
        if ($request->query->has('year')) {
            $year = $request->query->get('year');
        }

        $years = \DB::table('member_books')
            ->selectRaw('YEAR(lend_at) AS `year`')
            ->groupBy(\DB::raw('YEAR(lend_at)'))
            ->get();

        $month = (int) date('m');
        if ($request->query->has('month')) {
            $month = $request->query->get('month');
        }

        $months = [];
        for ($m= 1; $m <= 12; $m++) {
            $months[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
        }

        return view('statistics.books', compact('year', 'years', 'month', 'months'));
    }
}
