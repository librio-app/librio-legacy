<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Administration\Member;
use App\Http\Requests\Member\Lend as Request;
use App\Http\Requests\Request as DefaultRequest;
use App\Models\Catalog\Barcode;
use App\Service\ReservationService;
use Carbon\Carbon;

class LendController extends Controller
{
    /**
     * @var ReservationService
     */
    private $reservationService;

    /**
     * TakeInController constructor.
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        parent::__construct();
        $this->reservationService = $reservationService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DefaultRequest $request)
    {
        $search = $request->get('search');

        $members = null;
        if (isset($search)) {
            $member = Member::where('code', '=', $search)->first();
            if ($member instanceof Member) {
                return redirect()->route('lend.member', ['member' => $member->id]);
            }

            $members = Member::collect();
        }

        return view('member.lend.index', compact('search', 'members'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview(Member $member)
    {
        $subscription = $member->subscriptions()->first();
        $lended = $member->lended()->get();

        $notAvailableReservations = $this->reservationService->getNotAvailableReservations($member)->map(function ($reservation) {
            return $reservation->id;
        })->toArray();
        $reservations = $member->reservations()->get();

        $costs = array_reduce($member->takeIn(true)->get()->toArray(), function (float $carry, $item) {
            return $carry + ($item['penalty'] + $item['costs']);
        }, 0.0);

        $subscriptionIsEnding = false;
        $withinMonth = Carbon::now();
        if ($subscription !== null && $subscription->pivot->expire_date !== null
            && Carbon::createFromFormat('Y-m-d H:i:s', $subscription->pivot->expire_date)->subDays(30) < $withinMonth) {
            $subscriptionIsEnding = true;
        }

        return view('member.lend.lend', compact(
            'member',
            'subscription',
            'lended',
            'notAvailableReservations',
            'reservations',
            'costs',
            'subscriptionIsEnding'
        ));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request, Member $member)
    {
        $barcode = Barcode::where(['barcode' => $request->get('barcode')])->first();
        $barcode->save();

        $member->lended()->create([
            'member_id' => $member->id,
            'book_barcode_id' => $barcode->id,
            'lend_at' => new \DateTime()
        ]);

        // remove reservation if lended
        $reservation = $this->reservationService->getReservation($barcode, $member);
        if ($reservation){
           $reservation->delete();
        }

        $lended = $member->lended()->get();
        $lendedView = view('member.lend.books', ['lended' => $lended])->render();

        $reservations = $member->reservations()->get();
        $notAvailableReservations = $this->reservationService->getNotAvailableReservations($member);
        $reservationsView = view('member.lend.reservations', ['reservations' => $reservations, 'notAvailableReservations' => $notAvailableReservations->map(function ($reservation) {
            return $reservation->id;
        })->toArray()])->render();
        $totalReservations = view('partials.info-box.total-reservations', ['reservations' => $reservations, 'notAvailableReservations' => $notAvailableReservations])->render();

        $subscription = $member->subscriptions()->first();
        if ($subscription) {
            $totalLended = view('partials.info-box.total-lended', ['subscription' => $subscription, 'lended' => $lended])->render();
        }

        return response()->json([
            'success' => true,
            'error' => false,
            'message' => '',
            'total-lended' => $totalLended ?? null,
            'total-reservations' => $totalReservations ?? null,
            'reservations-available' => count($reservations) - count($notAvailableReservations) === 0,
            'lended' => $lendedView,
            'reservations' => $reservationsView,
        ]);
    }
}
