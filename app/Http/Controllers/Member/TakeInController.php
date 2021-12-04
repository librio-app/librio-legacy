<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\TakeIn as Request;
use App\Models\Administration\Subscription;
use App\Models\Catalog\Barcode;
use App\Models\Member\Book;
use App\Service\LendingCostsService;
use App\Service\ReservationService;
use App\Service\ThemeService;

class TakeInController extends Controller
{
    /**
     * @var ReservationService
     */
    private $reservationService;

    /**
     * @var LendingCostsService
     */
    private $lendingCostsService;

    /**
     * @var ThemeService
     */
    private $themeService;

    /**
     * TakeInController constructor.
     * @param ReservationService $reservationService
     * @param LendingCostsService $penaltyService
     * @param ThemeService $themeService
     */
    public function __construct(ReservationService $reservationService, LendingCostsService $penaltyService, ThemeService $themeService)
    {
        parent::__construct();
        $this->reservationService = $reservationService;
        $this->lendingCostsService = $penaltyService;
        $this->themeService = $themeService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $barcode = \request('barcode');

        return view('member.take-in.index', compact('barcode'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $barcode = Barcode::where(['barcode' => $request->get('barcode')])->first();

        /** @var Book $lendedBook */
        $lendedBook = $barcode->lended()->first();
        $lendedBook->take_in_at = new \DateTime();
        /** @var Subscription|null $subscription */
        $subscription = $lendedBook->member->subscriptions()->first();
        $penalty = $this->lendingCostsService->calculatePenalty($lendedBook, $subscription);
        $costs = $this->lendingCostsService->calculateCosts($lendedBook, $subscription);
        $lendedBook->penalty = $penalty;
        $lendedBook->costs = $costs;
        $lendedBook->save();

        $barcode->save();

        // get lended books
        $lended = $lendedBook->member->lended()->get();

        $html = view('member.take-in.take-in', [
            'lended' => $lended,
            'member' => $lendedBook->member,
        ])->render();

        // check for reservation member
        $reservationMember = $this->reservationService->getReservationMember($barcode);
        $reservationHtml = null;
        if ($reservationMember) {
            $reservationHtml = view('member.take-in.reservation-alert', [
                'book' => $barcode->book,
                'barcode' => $barcode,
                'reservationMember' => $reservationMember,
            ])->render();

            // status is reserved
            $barcode->status = 'in_reservation';
            $barcode->save();
        }

        // check themes, give warning if themes found
        $themes = $this->themeService->getActiveThemes($barcode->book);
        $themesHtml = null;
        if ($themes->count() > 0) {
            $themesHtml = view('member.take-in.theme-alert', [
                'themeNames' => implode(', ', $themes->map(function ($item) {
                    return $item->name;
                })->toArray()),
                'book' => $barcode->book,
                'barcode' => $barcode,
            ])->render();
        }

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => '',
            'html' => $html,
            'reservation' => ($reservationMember !== null),
            'reservationHtml' => $reservationHtml,
            'themes' => $themes->count() > 0,
            'themesHtml' => $themesHtml,
            'memberId' => (string) $lendedBook->member->id,
        ]);
    }
}
