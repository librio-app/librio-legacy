@extends('layout.opac')

@section('title', __('Not Found'))
@section('header', '404 | ' . __('Not Found'))

@section('content')
    <div class="error-page">
        <h2 class="headline text-red">404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{ trans('errors.oops') }}</h3>

            <p>
                {{ trans('errors.not_found') }}
                <a href="{{ url('/') }}">{{ trans('general.dashboard') }}</a>
            </p>

            @include('partials.default.error')
        </div>
    </div>
@endsection
