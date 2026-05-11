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
                    <div class="btn-group btn-filter" role="group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                            <span class="fa fa-download"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item" id="download-books">{{ trans_choice('general.books', 2) }}</a>
                            <a href="#" class="dropdown-item" id="download-barcode-lending">{{ trans('general.barcode_lending_export') }} (CSV)</a>
                        </div>
                    </div>
                @endpermission
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('partials.books.bookstable')
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

            $('#download-books').click(function(e) {
                e.preventDefault();
                window.open('<?php echo route('books.download', request()->query()) ?>','_blank');
            });

            $('#download-barcode-lending').click(function(e) {
                e.preventDefault();
                window.open('<?php echo e(route('books.download', array_merge(request()->query(), ['export' => 'barcode_lending']))) ?>','_blank');
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
