<div class="table table-responsive">
    <table class="table table-striped table-hover" id="tbl-lended">
        <thead>
        <tr>
            <th class="col-md-3">{{ trans('general.title.default') }}</th>
            <th class="col-md-2">{{ trans_choice('general.authors', 1) }}</th>
            <th class="col-md-2">{{ trans_choice('general.barcodes', 1) }}</th>
            <th class="col-md-2">{{ trans('general.lend_at') }}</th>
            <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($lended))
            @foreach($lended as $item)
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
                    <td>
                        {{ $book->author->getName() }}
                    </td>
                    <td class="barcode">{{ $barcode->barcode }}</td>
                    <td>{{ $item->lend_at->format('d-m-Y') }} ({{ $item->lend_at->diffForHumans()  }})</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{ url('member/take-in?barcode=' . $barcode->barcode) }}">
                                <button type="submit" class="btn bg-yellow dropdown-toggle">
                                    <i class="fa fa-share"></i>
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>{{ trans('general.no_results') }}</td>
                <td></td><td></td><td></td><td></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
