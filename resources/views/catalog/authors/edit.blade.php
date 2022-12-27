@extends('layout.default')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.authors', 1)]))
@section('header', trans('general.title.edit', ['type' => trans_choice('general.authors', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.authors', 2) }}</li>
@endsection


@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::model($author, [
            'method' => 'PATCH',
            'url' => ['catalog/authors', $author->id],
            'role' => 'form',
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('first_name', trans('general.first_name'), 'bookmark') }}

            {{ Form::textGroup('last_name', trans('general.last_name'), 'bookmark') }}

            {{ Form::textGroup('code', trans('general.code'), 'key') }}

            {{ Form::dateRange('birthday', trans('general.birthday'), 'calendar') }}

            {{ Form::textareaGroup('description', trans('general.description')) }}

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-catalog-categories')
        <div class="box-footer">
            {{ Form::saveButtons() }}
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
            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            var nameElement = $("input[name='last_name']");
            var codeElement = $("input[name='code']");

            nameElement.on("change paste keyup", function () {
                codeElement.val(nameElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
                codeElement.trigger('change');
            });

            var code = $("input[name='code']").val();
            var formElement = codeElement.parent().parent();
            codeElement.on("change paste keyup", function () {
                $.ajax({
                    url: '<?php echo url('api/catalog/authors/codes') ?>',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache, private'
                    },
                    method: 'POST',
                    dataType: 'json',
                    processData: false,
                    data: $("input[name='code']").val(),
                    success: function (data) {
                        codeElement.parent().parent().removeClass('has-error');
                        $(".help-block").remove();

                        if (data.duplicated && code !== data.code) {
                            formElement.addClass('has-error');

                            formElement.append('<p class="help-block">' + data.message + '</p>');
                        }
                    }
                });
            });
        });
    </script>
@endpush
