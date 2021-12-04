<table class="table table-striped table-hover" id="tbl-reservations">
    <thead>
    <tr>
        <th class="col-md-3">{{ trans('general.title.default') }}</th>
        <th class="col-md-2">{{ trans_choice('general.barcodes', 1) }}</th>
        <th class="col-md-2">{{ trans('general.available') }}</th>
        <th class="col-md-2">{{ trans('general.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @if(count($reservations))
        @foreach($reservations as $item)
            <?php
            $barcode = $item->barcode;
            $book = $item->barcode->book;
            ?>
            <tr>
                <td>
                    <a href="{{ url('catalog/books/' . $book->id . '/details') }}">
                        {{ $book->title }}
                    </a>
                </td>
                <td class="barcode">{{ $barcode->barcode }}</td>
                <td>
                    @include('partials.button.book_status', ['item' => $item->barcode, 'allowed' => false])
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                            <i class="fa fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            @permission('delete-member-reservations')
                            <li class="divider"></li>
                            <li>{!! Form::deleteLink($item, 'member/reserve', 'reservations', 'barcode') !!}</li>
                            @endpermission
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td>{{ trans('general.no_results') }}</td>
            <td></td><td></td><td></td>
        </tr>
    @endif
    </tbody>
</table>
