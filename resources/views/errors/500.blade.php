@extends('layout.opac')

@section('title', __('Server Error'))
@section('header', '500 | ' . __('Server Error'))

@section('content')
    <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{ trans('errors.oops') }}</h3>

            <p>
                {{ trans('errors.error') }}
                <a href="{{ url('/') }}">{{ trans('general.dashboard') }}</a>
            </p>

            @include('partials.default.error')
        </div>
    </div>
@endsection
