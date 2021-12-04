<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Reserve as Request;
use App\Models\Administration\Member;
use App\Models\Catalog\Barcode;
use App\Models\Member\Reservation;

class ReservationsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reservations = Reservation::with('member', 'barcode')->collect();

        return view('member.reservation.index', compact('reservations'));
    }

    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Member $member)
    {
        $barcode = Barcode::where(['barcode' => $request->get('reservation')])->first();

        $member->reservations()->create([
            'member_id' => $member->id,
            'book_barcode_id' => $barcode->id,
        ]);

        return redirect()->route('lend.member', ['member' => $member]);
    }

    /**
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Reservation $reservation)
    {
        $member = $reservation->member()->first();
        $reservation->delete();

        return redirect()->route('lend.member', ['member' => $member->id]);
    }
}
