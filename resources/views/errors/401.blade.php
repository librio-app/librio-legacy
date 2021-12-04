@if (Auth::user()->isAdmin())
    @extends('layout.default')
@else
    @extends('layout.opac')
@endif

@section('title', __('Unauthorized'))
@section('header', '401 | ' . __('Unauthorized'))

@section('content')
    <div class="error-page">
        <h2 class="headline text-red">401</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{ trans('errors.oops') }}</h3>

            <p>
                {{ trans('errors.permissions') }}
            </p>

            @include('partials.default.error')
        </div>
    </div>
@endsection
