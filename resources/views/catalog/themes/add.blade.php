@extends('layout.default')

@section('title', trans_choice('general.themes', 1) . ' "' . $theme->name . '" - ' .  strtolower(trans('general.add_books')))
@section('header', trans_choice('general.themes', 1) . ' "' . $theme->name . '" - ' .  strtolower(trans('general.add_books')))
@section('breadcrumb')
    <li><a href="{{ url('/catalog/themes') }}">{{ trans_choice('general.themes', 2) }}</a></li>
    <li><a href="{{ url('/catalog/themes/' . $theme->id . '/edit') }}">{{ trans_choice('general.themes', 1) }} {{ $theme->name }}</a></li>
    <li class="active">{{ trans_choice('general.themes', 1) }} {{ strtolower(trans('general.add_books')) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::open([
            'method' => 'POST',
            'url' => ['catalog/themes/' . $theme->id . '/add/book'],
            'role' => 'form',
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('barcode', trans_choice('general.barcodes', 1), 'barcode', ['autofocus' => true], null) }}
        </div>
        <!-- /.box-body -->

        @permission('update-catalog-books')
        <div class="box-footer">
            {{ Form::saveButtons('catalog/books') }}
        </div>
        @endpermission

        {!! Form::close() !!}
    </div>

    <h3>{{ trans_choice('general.books', 2) }}</h3>

    @include('catalog.themes.books', ['books' => $books])
@stop

@push('scripts')

@endpush
