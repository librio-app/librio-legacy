@extends('layout.default')

@section('title', trans('general.title.new', ['type' => trans_choice('general.categories', 1)]))
@section('header', trans('general.title.new', ['type' => trans_choice('general.categories', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.categories', 2) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::open(['url' => 'catalog/categories', 'role' => 'form']) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'bookmark', ['autofocus' => true]) }}

            {{ Form::textGroup('code', trans('general.code'), 'key') }}

            {{ Form::textareaGroup('description', trans('general.description')) }}

            {{ Form::radioGroup('enabled', trans('general.enabled'), true) }}
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            {{ Form::saveButtons('catalog/categories') }}
        </div>

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

            var nameElement = $("input[name='name']");

            nameElement.add(nameElement).on("change paste keyup", function () {
                codeElement.val(nameElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
                codeElement.trigger('change');
            });

            var codeElement = $("input[name='code']");
            var formElement = codeElement.parent().parent();
            codeElement.on("change paste keyup", function () {
                $.ajax({
                    url: '<?php echo url('api/catalog/categories/codes') ?>',
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

                        if (data.duplicated) {
                            formElement.addClass('has-error');

                            formElement.append('<p class="help-block">' + data.message + '</p>');
                        }
                    }
                });
            });
        });
    </script>
@endpush
