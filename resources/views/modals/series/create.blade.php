<div class="modal fade in" id="modal-create-series" style="display: block;">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('general.title.new', ['type' => trans_choice('general.series', 1)]) }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'form-create-series', 'role' => 'form']) !!}

                <div class="box-body">
                    {{ Form::textGroup('title', trans('general.title.default'), 'bookmark') }}

                    {{ Form::textGroup('code', trans('general.code'), 'key') }}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'button', 'id' =>'button-create-series', 'class' => 'btn btn-success button-submit', 'data-loading-text' => trans('general.loading')]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-create-series').modal('show');

        let titleElement = $("#modal-create-series #title");
        let codeElement = $("#modal-create-series #code");

        titleElement.on("change paste keyup", function () {
            codeElement.val(titleElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
            codeElement.trigger('change');
        });

        var formElement = codeElement.parent().parent();
        codeElement.on("change paste keyup", function () {
            $.ajax({
                url: '<?php echo url('api/catalog/series/codes') ?>',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Cache-Control': 'no-cache, private'
                },
                method: 'POST',
                dataType: 'json',
                processData: false,
                data: codeElement.val(),
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

        $(document).on('click', '#button-create-series', function (e) {
            $('#modal-create-series .modal-header').before('<span id="span-loading" style="position: absolute; height: 100%; width: 100%; z-index: 99; background: #3c8dbc; opacity: 0.4;"><i class="fa fa-spinner fa-spin" style="font-size: 10em !important;margin-left: 35%;margin-top: 8%;"></i></span>');

            $.ajax({
                url: '{{ url("modals/series") }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                type: 'POST',
                dataType: 'JSON',
                data: $("#form-create-series").serialize(),
                beforeSend: function () {
                    $(".form-group").removeClass("has-error");
                    $(".help-block").remove();
                },
                complete: function () {
                    $('#button-create-series').button('reset');
                },
                success: function (json) {
                    var data = json['data'];

                    $('#span-loading').remove();

                    $('#modal-create-series').modal('hide');

                    $("#series_id").append('<option value="' + data.id + '" selected="selected">' + data.title + '</option>');
                    $('#series_id').trigger('change');
                    $("#series_id").select2('refresh');
                },
                error: function (error, textStatus, errorThrown) {
                    $('#span-loading').remove();

                    if (error.responseJSON.errors.title) {
                        $("#modal-create-series input[name='title']").parent().parent().addClass('has-error');
                        $("#modal-create-series input[name='title']").parent().after('<p class="help-block">' + error.responseJSON.errors.title + '</p>');
                    }

                    if (error.responseJSON.errors.code) {
                        $("#modal-create-series input[name='code']").parent().parent().addClass('has-error');
                        $("#modal-create-series input[name='code']").parent().after('<p class="help-block">' + error.responseJSON.errors.code + '</p>');
                    }
                }
            });
        });
    });
</script>
