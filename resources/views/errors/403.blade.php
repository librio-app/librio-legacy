@if (Auth::user()->isAdmin())
    @extends('layout.default')
@else
    @extends('layout.opac')
@endif

@section('title', __('Forbidden'))
@section('header', '403 | ' . __($exception->getMessage() ?: 'Forbidden'))

@section('content')
    <div class="error-page">
        <h2 class="headline text-red">403</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> {{ trans('errors.oops') }}</h3>

            <p>
                {{ trans('errors.permissions') }}
            </p>

            @include('partials.default.error')
        </div>
    </div>
@endsection
