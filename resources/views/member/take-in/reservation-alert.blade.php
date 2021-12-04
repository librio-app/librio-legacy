<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i>{{ trans('general.reservation_found') }}</h4>
    {{ trans('general.reservation_text', ['title' => $book->title, 'barcode' => $barcode->barcode, 'name' => $reservationMember->getName(), 'code' => $reservationMember->code]) }}
</div>
