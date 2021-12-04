<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chart\Lended as Request;
use Chartisan\PHP\Chartisan;

class ChartController extends Controller
{
    public function year(Request $request)
    {
        $year = date('Y');
        if ($request->query->has('year')) {
            $year = $request->query->get('year');
        }

        $lended = \DB::table('member_books')
            ->selectRaw('MONTH(lend_at) AS `month`, COUNT(id) AS `total`')
            ->whereRaw('YEAR(lend_at) = :year', ['year' => $year])
            ->groupBy(\DB::raw('MONTH(lend_at)'))
            ->pluck('total', 'month');

        $labels = [];
        $dataset = [];
        for ($month = 1; $month <= 12; $month++)  {
            $labels[] = \DateTime::createFromFormat('m', $month)->format('F');
            if (isset($lended[$month])) {
                $dataset[] = $lended[$month];
            } else {
                $dataset[] = 0;
            }
        }

        $chart = Chartisan::build()
            ->labels($labels)
            ->dataset(trans('general.total'), $dataset);

        return $chart->toJSON();
    }

    public function month(Request $request)
    {
        $year = date('Y');
        if ($request->query->has('year')) {
            $year = $request->query->get('year');
        }

        $month = date('m');
        if ($request->query->has('month')) {
            $month = $request->query->get('month');
        }

        $lended = \DB::table('member_books')
            ->selectRaw('DAY(lend_at) AS day, COUNT(id) AS `total`')
            ->whereRaw('YEAR(lend_at) = :year', ['year' => $year])
            ->whereRaw('MONTH(lend_at) = :month', ['year' => $month])
            ->groupBy(\DB::raw('DATE_FORMAT(lend_at, \'%W %d %M\')'))
            ->orderBy('lend_at')
            ->pluck('total', 'day');

        $labels = [];
        $dataset = [];
        for ($date = 1; $date <= 31; $date++)  {
            $time = mktime(12, 0, 0, $month, $date, $year);
            if (date('n', $time) === $month) {
               $labels[] = date('d F Y', $time);
               if (isset($lended[$date])) {
                   $dataset[] = $lended[$date];
               } else {
                   $dataset[] = 0;
               }
            }
        }

        $chart = Chartisan::build()
            ->labels($labels)
            ->dataset(trans('general.total'), $dataset);

        return $chart->toJSON();
    }
}
