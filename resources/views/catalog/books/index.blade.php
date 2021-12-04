@extends('layout.default')

@section('title', trans_choice('general.books', 2))
@section('header', trans_choice('general.books', 2))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.books', 2) }}</li>
@endsection

@section('new_button')
    @permission('create-catalog-books')
    <span class="new-button"><a href="{{ url('catalog/books/create') }}" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a></span>
    @endpermission

    @permission('update-catalog-books')
    <span class="new-button"><a href="{{ url('catalog/barcode/status') }}" class="btn btn-primary btn-sm"><span class="fa fa-bell"></span> &nbsp;{{ trans('general.change_status') }}</a></span>
    @endpermission
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'catalog/books', 'role' => 'form', 'method' => 'GET']) !!}
            <div id="items" class="pull-left box-filter">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
                {!! Form::text('barcode', request('barcode'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans_choice('general.barcodes', 1)]) !!}
                {!! Form::select('authors[]', $authors, request('authors'), ['id' => 'filter-authors', 'class' => 'form-control input-filter input-lg', 'multiple' => 'multiple']) !!}
                {!! Form::select('categories[]', $categories, request('categories'), ['id' => 'filter-categories', 'class' => 'form-control input-filter input-lg', 'multiple' => 'multiple']) !!}
                {!! Form::button('<span class="fa fa-filter"></span> &nbsp;' . trans('general.filter'), ['type' => 'submit', 'class' => 'btn btn-sm btn-default btn-filter']) !!}
            </div>

            <div class="pull-right">
                <span class="title-filter hidden-xs">{{ trans('general.show') }}:</span>
                {!! Form::select('limit', $limits, request('limit', 25), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}

                @permission('read-administration-export')
                    {!! Form::button('<span class="fa fa-download"></span>', ['id' => 'download-books', 'type' => 'button', 'class' => 'btn btn-sm btn-danger btn-filter button-submit']) !!}
                @endpermission
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
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
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $books, 'type' => 'books'])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#filter-authors").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.authors', 1)]) }}"
            });

            $("#filter-categories").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.categories', 1)]) }}"
            });

            $('#download-books').click(function() {
                window.open('<?php echo route('books.download', request()->query()) ?>','_blank');
            });

            // on first focus (bubbles up to document), open the menu
            $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
                $(e.target).data("select2").$selection.one('focus focusin', function (e) {
                    e.stopPropagation();
                });
            });
        });
    </script>
@endpush
