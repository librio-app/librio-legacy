<?php

namespace App\Service;

use App\Models\Administration\Member;
use App\Models\Catalog\Barcode;
use App\Models\Member\Reservation;
use Illuminate\Support\Collection;

class ReservationService
{
    /**
     * @param Barcode $barcode
     * @return Member|null
     */
    public function getReservationMember(Barcode $barcode)
    {
        /** @var Reservation|null $reservation */
        $reservation = Reservation::where('book_barcode_id', $barcode->id)->whereNull('deleted_at')->orderBy('created_at')->first();
        if ($reservation) {
            return $reservation->member()->first();
        }

        return null;
    }

    /**
     * @param Member $member
     * @return Collection|Reservation[]
     */
    public function getNotAvailableReservations(Member $member)
    {
        $reservations = \DB::table('member_reservations')
            ->select('member_reservations.*')
            ->join('book_barcodes', 'member_reservations.book_barcode_id', '=', 'book_barcodes.id')
            ->join('member_books', 'member_books.book_barcode_id', '=', 'book_barcodes.id')
            ->join('books', 'book_barcodes.book_id', '=', 'books.id')
            ->whereIn('book_barcodes.status', ['in_repair', 'lost', 'taken_in', 'lended'])
            ->where('books.enabled', 1)
            ->whereNull('member_books.take_in_at')
            ->where('member_reservations.member_id', $member->id)
            ->whereNull('member_reservations.deleted_at')
            ->orderBy('member_reservations.created_at')
            ->groupBy('member_reservations.id')
            ->get();

        return $reservations;
    }

    /**
     * @param Barcode $barcode
     * @param Member $member
     * @return Reservation|null
     */
    public function getReservation(Barcode $barcode, Member $member)
    {
        $reservation = Reservation::where('book_barcode_id', $barcode->id)->where('member_id', $member->id)->whereNull('deleted_at')->orderBy('created_at')->first();
        if ($reservation instanceof Reservation) {
            return $reservation;
        }

        return null;
    }
}
