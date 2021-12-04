@extends('layout.install')

@section('title', trans('install.title'));

@section('content')
    <div class="register-box-body">
        <p class="login-box-msg">{{ trans('install.steps.requirements') }}</p>

        <div class="col-md-14">
            @include('flash::message')
        </div>

        {!! Form::open(['url' => url()->current(), 'role' => 'form']) !!}

            <div class="register-box-footer">
                <div class="form-group">
                    <div class="text-right">
                        @if (Request::is('install/requirements'))
                            <a href="{{ url('install/requirements') }}" class="btn btn-success"> {{ trans('install.refresh') }} &nbsp;<i class="fa fa-refresh"></i></a>
                        @else
                            {!! Form::button(trans('install.next') . ' &nbsp;<i class="fa fa-arrow-right"></i>', ['type' => 'submit', 'id' => 'next-button', 'class' => 'btn btn-success']) !!}
                        @endif
                    </div>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
    <!-- /.form-box -->
@endsection