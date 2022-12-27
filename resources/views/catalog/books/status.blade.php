@extends('layout.default')

@section('title', trans('general.change_status'))
@section('header', trans('general.change_status'))
@section('breadcrumb')
    <li><a href="{{ url('/catalog/books') }}">{{ trans_choice('general.books', 2) }}</a></li>
    <li class="active">{{ trans('general.change_status') }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::open([
            'method' => 'POST',
            'url' => ['catalog/barcode/status'],
            'role' => 'form',
        ]) !!}

        <div class="box-body">
            <input hidden="hidden" name="redirect" type="text" id="redirect" value="{{ (int) $redirect }}">

            {{ Form::textGroup('barcode', trans_choice('general.barcodes', 1), 'barcode', ['autofocus' => true], $barcode) }}

            {{ Form::selectGroup('status', trans('barcode.status'), 'bookmark', array_map(function ($value) {
                return trans('barcode.' . $value);
            }, array_filter(config('enums.barcode_status'), function ($status) {
                if ($status === 'lended') {
                    return false;
                }
                return true;
            })), $status ?? null) }}
        </div>
        <!-- /.box-body -->

        @permission('update-catalog-books')
        <div class="box-footer">
            {{ Form::saveButtons('catalog/books') }}
        </div>
        @endpermission

        {!! Form::close() !!}
    </div>
@stop

@push('scripts')

@endpush
