<?php


namespace App\Contracts\Validation\Rule;

use Illuminate\Contracts\Validation\Rule;

class ReservationNotSamePerson implements Rule
{
    /**
     * @var string
     */
    private $barcode;

    /**
     * @var int
     */
    private $memberId;

    /**
     * ReservationNotSamePerson constructor.
     * @param string $barcode
     * @param int $memberId
     */
    public function __construct(string $barcode, int $memberId)
    {
        $this->barcode = $barcode;
        $this->memberId = $memberId;
    }

    public function passes($attribute, $value)
    {
        $lended = \DB::table('member_books')
            ->join('book_barcodes', 'member_books.book_barcode_id', '=', 'book_barcodes.id')
            ->where('book_barcodes.barcode', $this->barcode)
            ->where('member_books.member_id', $this->memberId)
            ->whereNull('member_books.take_in_at')
            ->get()->first();

        if ($lended) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return trans('validation.reservation_person');
    }
}
