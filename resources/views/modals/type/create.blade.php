<div class="modal fade in" id="modal-create-type" style="display: block;">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('general.title.new', ['type' => trans_choice('general.types', 1)]) }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'form-create-type', 'role' => 'form']) !!}

                <div class="box-body">
                    {{ Form::textGroup('name', trans('general.name'), 'bookmark') }}

                    {{ Form::textGroup('code', trans('general.code'), 'key') }}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'button', 'id' =>'button-create-type', 'class' => 'btn btn-success button-submit', 'data-loading-text' => trans('general.loading')]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-create-type').modal('show');

        let nameElement = $("#modal-create-type #name");
        let codeElement = $("#modal-create-type #code");

        nameElement.on("change paste keyup", function () {
            codeElement.val(nameElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
            codeElement.trigger('change');
        });

        var formElement = codeElement.parent().parent();
        codeElement.on("change paste keyup", function () {
            $.ajax({
                url: '<?php echo url('api/catalog/types/codes') ?>',
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

        $(document).on('click', '#button-create-type', function (e) {
            $('#modal-create-type .modal-header').before('<span id="span-loading" style="position: absolute; height: 100%; width: 100%; z-index: 99; background: #3c8dbc; opacity: 0.4;"><i class="fa fa-spinner fa-spin" style="font-size: 10em !important;margin-left: 35%;margin-top: 8%;"></i></span>');

            $.ajax({
                url: '{{ url("modals/type") }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                type: 'POST',
                dataType: 'JSON',
                data: $("#form-create-type").serialize(),
                beforeSend: function () {
                    $(".form-group").removeClass("has-error");
                    $(".help-block").remove();
                },
                complete: function () {
                    $('#button-create-type').button('reset');
                },
                success: function (json) {
                    var data = json['data'];

                    $('#span-loading').remove();

                    $('#modal-create-type').modal('hide');

                    $("#type_id").append('<option value="' + data.id + '" selected="selected">' + data.name + '</option>');
                    $('#type_id').trigger('change');
                    $("#type_id").select2('refresh');
                },
                error: function (error, textStatus, errorThrown) {
                    $('#span-loading').remove();

                    if (error.responseJSON.errors.first_name) {
                        $("#modal-create-type input[name='name']").parent().parent().addClass('has-error');
                        $("#modal-create-type input[name='name']").parent().after('<p class="help-block">' + error.responseJSON.errors.name + '</p>');
                    }

                    if (error.responseJSON.errors.code) {
                        $("#modal-create-type input[name='code']").parent().parent().addClass('has-error');
                        $("#modal-create-type input[name='code']").parent().after('<p class="help-block">' + error.responseJSON.errors.code + '</p>');
                    }
                }
            });
        });
    });
</script>
