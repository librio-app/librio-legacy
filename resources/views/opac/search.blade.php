@extends('layout.opac')

@section('title', trans_choice('general.opac', 1) . ' ' . trans('general.search'))
@section('header', trans_choice('general.opac', 1) . ' ' .  strtolower(trans('general.results')) . (($search) ? ': \'' . $search . '\'' : ''))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.opac', 1) }} {{ strtolower(trans('general.results')) }}</li>
@endsection

@section('content')
    <div class="box">
        <div class="box-footer">
            <div class="col-xs-2" style="margin: 0.5rem 0 0.5rem 0">@sortablelink('title', trans('general.title.default'))</div>
            <div class="col-xs-2" style="margin: 0.5rem 0 0.5rem 0">@sortablelink('author.last_name', trans_choice('general.authors', 1))</div>
            <div class="col-xs-2" style="margin: 0.5rem 0 0.5rem 0">@sortablelink('series_nr', trans_choice('general.series', 1))</div>

            <div class="form-group col-md-6 no-margin" style="padding-right: 0">
                <a href="{{ url('opac/search') }}" class="btn btn-primary pull-right" style="margin-left: 1rem"><span class="fa fa-search"></span> &nbsp;{{ trans('general.show_all') }}</a>
                <a href="{{ url('opac') }}" class="btn btn-success pull-right" style="margin-left: 1rem"><span class="fa fa-list"></span> &nbsp;{{ trans('general.search_again') }}</a>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            @if (count($books))
                <ul class="products-list product-list-in-box">
                @foreach($books as $book)
                    <li class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-img">
                                    <?php $random = 3; // $random = rand(1, 3); ?>
                                    <img src="{{ asset("images/book-{$random}.png") }}" alt="Book Image">
                                </div>
                                <div class="product-info">
                                    <span class="product-title">
                                        @if(Auth()->user() instanceof App\Models\User && Auth::user()->isAdmin())
                                            <a href="{{ url('catalog/books/' . $book->id . '/details') }}"><b>{{ $book->title }}</b></a>
                                        @else
                                            <b>{{ $book->title }}</b>
                                        @endif

                                        @if (isset($book->description))
                                            <a class="label label-default pull-right" data-toggle="collapse" href="#description-{{ $book->id }}" role="button" aria-expanded="false" aria-controls="description-{{ $book->id }}" >{{ trans('general.read_more') }}</a>
                                        @endif

                                        @if (isset($book->series_id))
                                            <a class="label label-primary pull-right" style="margin-right: 0.5rem" href="{{ url('opac/search?serie=' . $book->series_id) }}">{{ trans_choice('general.series', 1) }} {{ ($book->series_nr) ? '#' . $book->series_nr : '' }}</a>
                                        @endif
                                    </span>
                                    <span class="product-description"><b>{{ trans_choice('general.categories', 1) }}:</b> <a href="{{ url('opac/search?category=' . $book->category->id) }}">{{ $book->category->name }}</a></span>
                                    <span class="product-description"><b>{{ trans_choice('general.authors', 1) }}:</b> <a href="{{ url('opac/search?author=' . $book->author->id) }}">{{ $book->author->getName() }}</a></span>
                                    <span class="product-description"><b>{{ trans_choice('general.publishers', 1) }}:</b> {{ $book->publisher->name }}</span>
                                    <div class="collapse" id="description-{{ $book->id }}">
                                        <div class="card card-body">
                                        <span class="product-description">{{ mb_strimwidth($book->description ?? '-', 0, 500, '...') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 product-barcodes">
                                <table class="table table-responsive">
                                    <tbody>
                                        <?php $first = true; ?>
                                        @foreach($book->barcodes as $barcode)
                                            <tr>
                                                <td class="barcode" <?php echo ($first) ? 'style="border-top: 0px"' : '' ?>>{{ $barcode->barcode }}</td>
                                                <td class="text-right" <?php echo ($first) ? 'style="border-top: 0px; width: 40px"' : 'style="width: 40px"' ?><?php $first = false; ?>>
                                                    @include('partials.button.book_status', ['item' => $barcode, 'allowed' => Auth()->user() instanceof App\Models\User && Auth::user()->isAdmin()])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @else
                <div class="row">
                    <div class="col-xs-12">
                        <p class="lead" style="margin-bottom: 0">{{ trans('general.no_results') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if (count($books))
        <div class="box">
            <div class="box-footer">
                @include('partials.default.pagination', ['items' => $books, 'type' => 'books'])
            </div>
        </div>
    @endif
@stop
