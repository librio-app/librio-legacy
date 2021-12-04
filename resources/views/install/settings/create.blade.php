@extends('layout.install')

@section('title', trans('install.steps.settings'))

@section('content')
    <div class="register-box-body">
        <p class="login-box-msg">{{ trans('install.steps.settings') }}</p>

        <div class="col-md-14">
            @include('flash::message')
        </div>

        {!! Form::open(['url' => url()->current(), 'role' => 'form']) !!}

            {{ Form::textGroup('company_name', trans('install.settings.company_name'), 'id-card-o', ['required' => 'required'], old('company_name'), 'col-md-12') }}

            {{ Form::textGroup('user_email', trans('install.settings.admin_email'), 'envelope', ['required' => 'required'], old('user_email'), 'col-md-12') }}

            {{ Form::textGroup('user_name', trans('install.settings.admin_name'), 'user', ['required' => 'required'], old('user_name'), 'col-md-12') }}

            {{ Form::passwordGroup('user_password', trans('install.settings.admin_password'), 'key', ['required' => 'required'], old('user_password'), 'col-md-12') }}

            <div class="register-box-footer">
                <div class="form-group">
                    <div class="text-right">
                        {!! Form::button(trans('install.next') . ' &nbsp;<i class="fa fa-arrow-right"></i>', ['type' => 'submit', 'id' => 'next-button', 'class' => 'btn btn-success']) !!}
                    </div>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
@endsection
