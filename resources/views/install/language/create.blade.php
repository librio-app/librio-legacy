@extends('layout.install')

@section('title', trans('install.steps.language'))

@section('content')
    <div class="register-box-body">
        <p class="login-box-msg">{{ trans('install.steps.language') }}</p>

        {!! Form::open(['url' => url()->current(), 'role' => 'form']) !!}

           <div class="form-group">
                <div class="col-md-12">
                    <select name="lang" id="lang" size="2" class="form-control" style="margin-bottom: 15px">
                        @foreach (language()->allowed() as $code => $name)
                            <option value="{{ $code }}" @if ($code == 'en-GB') {{ 'selected="selected"' }} @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
           </div>

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