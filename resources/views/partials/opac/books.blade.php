<div class="table table-responsive">
    <table class="table table-striped table-hover" id="tbl-lended">
        <thead>
        <tr>
            <th class="col-md-3">{{ trans('general.title.default') }}</th>
            <th class="col-md-2">{{ trans_choice('general.authors', 1) }}</th>
            <th class="col-md-2">{{ trans_choice('general.series', 1) }}</th>
            <th class="col-md-2">{{ trans_choice('general.barcodes', 1) }}</th>
            <th class="col-md-2">{{ trans('general.lend_at') }}</th>
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
                        {{ $book->title }}
                    </td>
                    <td>
                        <a href="{{ route('search', ['author' => $book->author->id]) }}">
                            {{ $book->author->getName() }}
                        </a>
                    </td>
                    <td>
                        @if (isset($book->series_id))
                            <a href="{{ route('search', ['serie' => $book->series_id]) }}">
                                {{ ($book->series_nr) ? '#' . $book->series_nr : '' }}
                            </a>
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="barcode">{{ $barcode->barcode }}</td>
                    <td>{{ $item->lend_at->format('d-m-Y') }} ({{ $item->lend_at->diffForHumans()  }})</td>
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
