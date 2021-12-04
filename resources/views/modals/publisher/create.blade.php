<div class="modal fade in" id="modal-create-publisher" style="display: block;">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('general.title.new', ['type' => trans_choice('general.publishers', 1)]) }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'form-create-publisher', 'role' => 'form']) !!}

                <div class="box-body">
                    {{ Form::textGroup('name', trans('general.name'), 'bookmark') }}

                    {{ Form::textGroup('code', trans('general.code'), 'key') }}

                    {!! Form::hidden('enabled', '1', []) !!}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'button', 'id' =>'button-create-publisher', 'class' => 'btn btn-success button-submit', 'data-loading-text' => trans('general.loading')]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-create-publisher').modal('show');

        $('#birthday').datepicker({
            format: 'dd-mm-yyyy',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });

        let nameElement = $("#modal-create-publisher #name");
        let codeElement = $("#modal-create-publisher #code");

        nameElement.on("change paste keyup", function () {
            codeElement.val(nameElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
            codeElement.trigger('change');
        });

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

        $(document).on('click', '#button-create-publisher', function (e) {
            $('#modal-create-publisher .modal-header').before('<span id="span-loading" style="position: absolute; height: 100%; width: 100%; z-index: 99; background: #3c8dbc; opacity: 0.4;"><i class="fa fa-spinner fa-spin" style="font-size: 10em !important;margin-left: 35%;margin-top: 8%;"></i></span>');

            $.ajax({
                url: '{{ url("modals/publisher") }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                type: 'POST',
                dataType: 'JSON',
                data: $("#form-create-publisher").serialize(),
                beforeSend: function () {
                    $(".form-group").removeClass("has-error");
                    $(".help-block").remove();
                },
                complete: function () {
                    $('#button-create-publisher').button('reset');
                },
                success: function (json) {
                    var data = json['data'];

                    $('#span-loading').remove();

                    $('#modal-create-publisher').modal('hide');

                    $("#publisher_id").append('<option value="' + data.id + '" selected="selected">' + data.name + '</option>');
                    $('#publisher_id').trigger('change');
                    $("#publisher_id").select2('refresh');
                },
                error: function (error, textStatus, errorThrown) {
                    $('#span-loading').remove();

                    if (error.responseJSON.errors.name) {
                        $("#modal-create-publisher input[name='name']").parent().parent().addClass('has-error');
                        $("#modal-create-publisher input[name='name']").parent().after('<p class="help-block">' + error.responseJSON.errors.name + '</p>');
                    }

                    if (error.responseJSON.errors.code) {
                        $("#modal-create-publisher input[name='code']").parent().parent().addClass('has-error');
                        $("#modal-create-publisher input[name='code']").parent().after('<p class="help-block">' + error.responseJSON.errors.code + '</p>');
                    }
                }
            });
        });
    });
</script>
