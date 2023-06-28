@extends('layout.opac')

@section('title', trans('general.lended_books'))
@section('header', trans('general.lended_books'))
@section('breadcrumb')
    <li class="active">{{ trans('general.lended_books') }}</li>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => route('lended'), 'role' => 'form', 'method' => 'GET']) !!}
            <div class="pull-left">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <div class="box-body">
            @include('partials.opac.books', ['lended' => $lended])
        </div>
        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $lended, 'type' => 'books'])
        </div>
    </div>
@stop

