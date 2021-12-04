@extends('layout.install')

@section('title', trans('install.steps.database'))

@section('content')
    <div class="register-box-body">
        <p class="login-box-msg">{{ trans('install.steps.database') }}</p>

        <div class="col-md-14">
            @include('flash::message')
        </div>

        {!! Form::open(['url' => url()->current(), 'role' => 'form']) !!}

            {{ Form::textGroup('hostname', trans('install.database.hostname'), 'server', ['required' => 'required'], old('hostname', 'localhost'), 'col-md-12') }}

            {{ Form::textGroup('username', trans('install.database.username'), 'user', ['required' => 'required'], old('username'), 'col-md-12') }}

            {{ Form::passwordGroup('password', trans('install.database.password'), 'key', [], old('password'), 'col-md-12') }}

            {{ Form::textGroup('database', trans('install.database.name'), 'database', ['required' => 'required'], old('database'), 'col-md-12') }}

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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#next-button').attr('disabled', true);

            $('#hostname, #username, #database').keyup(function() {
                inputCheck();
            });
        });

        function inputCheck() {
            hostname = $('#hostname').val();
            username = $('#username').val();
            database = $('#database').val();

            if (hostname != '' && username != '' && database != '') {
                $('#next-button').attr('disabled', false);
            } else {
                $('#next-button').attr('disabled', true);
            }
        }
    </script>
@endpush
