@extends('layout.default')

@section('title', trans('general.title.details', ['type' => trans_choice('general.books', 1)]) . ' | ' . $book->title)
@section('header', trans('general.title.details', ['type' => trans_choice('general.books', 1)]))
@section('description', $book->title)
@section('breadcrumb')
    <li><a href="{{ url('/catalog/books') }}">{{ trans_choice('general.books', 2) }}</a></li>
    <li class="active">{{ trans('general.title.details', ['type' => trans_choice('general.books', 1)]) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <p class="lead">{{ $book->title }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width:50%">{{ trans('general.title.default') }}</th>
                                    <td>{{ $book->title }}</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">{{ trans_choice('general.series', 1) }}</th>
                                    <td><?php echo ($book->series) ?  "<a href='" . url('catalog/series/' . $book->series->id . '/edit') . "'>" . $book->series->title . ' #' . $book->series_nr . "</a>" : '-'  ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">{{ trans('general.code') }}</th>
                                    <td>{{ $book->code }}</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">{{ trans_choice('general.authors', 1) }}</th>
                                    <td>
                                        <a href="{{ url('/catalog/authors/' . $book->author->id . '/edit') }}">{{ $book->author->getName() }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:50%">{{ trans_choice('general.categories', 1) }}</th>
                                    <td>
                                        <a href="{{ url('/catalog/categories/' . $book->category->id . '/edit') }}">{{ $book->category->name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:50%">{{ trans_choice('general.publishers', 1) }}</th>
                                    <td>
                                        <a href="{{ url('/catalog/publishers/' . $book->publisher->id . '/edit') }}">{{ $book->publisher->name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:50%">{{ trans('general.isbn') }}</th>
                                    <td>{{ $book->isbn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">{{ trans('general.ean') }}</th>
                                    <td>{{ $book->ean  ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th style="width:50%;">{{ trans('general.enabled') }}</th>
                                    <td style="color: <?php echo ($book->enabled) ? '#00a65a' : '#9f191f' ?>">{{ $book->enabled ? trans('general.yes') : trans('general.no') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xs-7">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>{{ trans_choice('general.types', 1) }}</th>
                                    <td>{{ $book->type->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans_choice('general.created_date', 1) }}</th>
                                    <td>{{ $book->created_at->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans_choice('general.updated_date', 1) }}</th>
                                    <td>{{ $book->updated_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('general.description') }}</th>
                                    <td>{{ mb_strimwidth($book->description ?? '-', 0, 400, '...') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @permission('create-catalog-books')
                        <div class="form-group no-margin">
                            <a href="{{ url('catalog/books/create') }}" class="btn btn-success pull-right" style="margin-left: 1rem"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a>
                        </div>
                    @endpermission
                    <div class="form-group no-margin">
                        <a href="{{ url('catalog/books/' . $book->id . '/edit') }}" class="btn btn-default pull-right"><span class="fa fa-pencil"></span> &nbsp;{{ trans('general.edit') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3>{{ trans_choice('general.barcodes', 2) }}</h3>

    <div class="box box-primary">
        <div class="box-body">
            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-authors">
                    <thead>
                    <tr>
                        <th class="col-md-3">{{ trans_choice('general.barcodes', 1) }}</th>
                        <th class="col-md-2">{{ trans('general.created_date') }}</th>
                        <th class="col-md-2">{{ trans('general.updated_date') }}</th>
                        <th class="col-md-1">{{ trans('general.status') }}</th>
                        <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($barcodes))
                        @foreach($barcodes as $item)
                            <tr>
                                <td class="barcode">{{ $item->barcode }}</td>
                                <td>{{ $item->created_at->format('d-m-Y H:m') }}</td>
                                <td>{{ $item->updated_at->diffForHumans() }}</td>
                                <td>
                                    @include('partials.button.book_status', ['item' => $item, 'allowed' => true])
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('barcode.status', ['barcode' => $item->barcode]) }}">{{ trans('general.change_status') }}</a></li>
                                            @permission('delete-catalog-barcodes')
                                                @if ($item->allowedToDelete())
                                                    <li class="divider"></li>
                                                    <li>{!! Form::deleteLink($item, 'catalog/barcodes', '', 'barcode') !!}</li>
                                                @endif
                                            @endpermission
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ trans('general.no_results') }}</td>
                            <td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            {!! Form::open(['url' => 'catalog/book/' . $book->id . '/barcodes/add', 'role' => 'form']) !!}
                <div class="form-group col-md-4 no-margin no-padding pull-right {{ $errors->has('barcode') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                        <input class="form-control barcode" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('general.barcodes', 1)]) }}" value="{{ $newBarcode ?? '' }}" name="barcode" type="text" id="barcode">

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success button-submit" data-loading-text="{{ trans('general.loading') }}"><span class="fa fa-save"></span> &nbsp;{{ trans('general.add') }}</button>
                        </span>
                    </div>
                    {!! $errors->first('barcode', '<p class="help-block">:message</p>') !!}
                </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
