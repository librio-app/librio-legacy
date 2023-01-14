<div class="table table-responsive">
    <table class="table table-striped table-hover" id="tbl-books">
        <thead>
        <tr>
            <th class="col-md-2">@sortablelink('title', trans('general.title.default'))</th>
            <th class="col-md-1">{{ trans_choice('general.barcodes', 2) }}</th>
            <th class="col-md-2">{{ trans_choice('general.series', 1) }}</th>
            <th class="col-md-1">{{ trans_choice('general.categories', 1) }}</th>
            <th class="col-md-2">{{ trans_choice('general.authors', 1) }}</th>
            <th class="col-md-1">{{ trans('general.available') }}</th>
            <th class="col-md-1 hidden-xs">@sortablelink('enabled', trans('general.active'))</th>
            <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(count($books) > 0)
            @foreach($books as $item)
                <tr>
                    <td>
                        <a href="{{ url('catalog/books/' . $item->id . '/details') }}">
                            {{ $item->title }}
                        </a>
                    </td>
                    <td class="barcode">{{ ($item->barcodes->count() > 0) ? $item->barcodes->first() . (($item->barcodes->count() > 1) ? ', ' . '+' . ($item->barcodes->count() - 1) : '') : '-' }}</td>
                    <td>{{ isset($item->series) ? $item->series->title . (isset($item->series_nr) ? ' #' . $item->series_nr : '') : '-' }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->author->getName() }}</td>
                    <td>
                        @if ($item->barcodes->count() > 0)
                            @php
                                $available = array_filter($item->barcodes->toArray(), function ($barcode) {
                                    return $barcode['status'] === 'available';
                                });
                            @endphp

                            @if(count($available) >= 1)
                                <span class="label label-{!! Barcode::getLabel('available') !!}">{{ ((count($available) > 1) ? count($available) . ' ' : '') . trans('barcode.available') }}</span>
                            @else
                                @include('partials.button.book_status', ['item' => $item->barcodes->first(), 'allowed' => true])
                            @endif
                        @endif
                    </td>
                    <td>
                        @if ($item->enabled)
                            <span class="label label-success">{{ trans('general.enabled') }}</span>
                        @else
                            <span class="label label-danger">{{ trans('general.disabled') }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ url('catalog/books/' . $item->id . '/edit') }}">{{ trans('general.edit') }}</a></li>
                                @if ($item->enabled)
                                    <li><a href="{{ route('books.disable', $item->id) }}">{{ trans('general.disable') }}</a></li>
                                @else
                                    <li><a href="{{ route('books.enable', $item->id) }}">{{ trans('general.enable') }}</a></li>
                                @endif
                                @permission('delete-catalog-books')
                                <li class="divider"></li>
                                <li>{!! Form::deleteLink($item, 'catalog/books') !!}</li>
                                @endpermission
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <p>Er zijn geen boeken gevonden.</p>
        @endif
        </tbody>
    </table>
</div>
