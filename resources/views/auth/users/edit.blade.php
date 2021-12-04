@extends('layout.default')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.users', 1)]))
@section('header', trans('general.title.edit', ['type' => trans_choice('general.users', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.users', 2) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::model($user, [
            'method' => 'PATCH',
            'url' => ['auth/users', $user->id],
            'role' => 'form',
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'id-card-o') }}

            {{ Form::emailGroup('email', trans('general.email'), 'envelope') }}

            {{ Form::passwordGroup('password', trans('auth.password.current'), 'key', []) }}

            {{ Form::passwordGroup('password_confirmation', trans('auth.password.current_confirm'), 'key', []) }}

            {{ Form::selectGroup('locale', trans_choice('general.languages', 1), 'flag', language()->allowed()) }}

            <!-- {{ Form::fileGroup('picture',  trans_choice('general.pictures', 1)) }} -->

            @permission('read-admin-roles')
                {{ Form::checkboxGroup('roles', trans_choice('general.roles', 2), $roles, 'display_name') }}
            @endpermission

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-admin-users')
            <div class="box-footer">
                {{ Form::saveButtons('auth/users') }}
            </div>
            <!-- /.box-footer -->
        @endpermission

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            $("#locale").select2({
                language: {
                    noResults: function() {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.languages', 1)]) }}"
            });

            // on first focus (bubbles up to document), open the menu
            $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
                $(e.target).data("select2").$selection.one('focus focusin', function (e) {
                    e.stopPropagation();
                });
            });

            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endpush
