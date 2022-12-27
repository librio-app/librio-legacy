@extends('layout.default')

@section('title', trans('general.title.new', ['type' => trans_choice('general.series', 1)]))
@section('header', trans('general.title.new', ['type' => trans_choice('general.series', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.series', 2) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::open(['url' => 'catalog/series', 'role' => 'form']) !!}

        <div class="box-body">
            {{ Form::textGroup('title', trans('general.name'), 'bookmark', ['autofocus' => true]) }}

            {{ Form::textGroup('code', trans('general.code'), 'key') }}
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            {{ Form::saveButtons('catalog/series') }}
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            var titleElement = $("input[name='title']");
            var codeElement = $("input[name='code']");

            titleElement.on("change paste keyup", function () {
                codeElement.val(titleElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
                codeElement.trigger('change');
            });

            var code = $("input[name='code']").val();
            var formElement = codeElement.parent().parent();
            codeElement.on("change paste keyup", function () {
                $.ajax({
                    url: '<?php echo url('api/catalog/publishers/codes') ?>',
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
