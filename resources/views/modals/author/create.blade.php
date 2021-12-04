<div class="modal fade in" id="modal-create-author" style="display: block;">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('general.title.new', ['type' => trans_choice('general.authors', 1)]) }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'form-create-author', 'role' => 'form']) !!}

                <div class="box-body">
                    {{ Form::textGroup('first_name', trans('general.first_name'), 'bookmark') }}

                    {{ Form::textGroup('last_name', trans('general.last_name'), 'bookmark') }}

                    {{ Form::textGroup('code', trans('general.code'), 'key') }}

                    {{ Form::textareaGroup('description', trans('general.description')) }}

                    {!! Form::hidden('enabled', '1', []) !!}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'button', 'id' =>'button-create-author', 'class' => 'btn btn-success button-submit', 'data-loading-text' => trans('general.loading')]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-create-author').modal('show');

        $('#birthday').datepicker({
            format: 'dd-mm-yyyy',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });

        let nameElement = $("#modal-create-author #last_name");
        let codeElement = $("#modal-create-author #code");

        nameElement.on("change paste keyup", function () {
            codeElement.val(nameElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
            codeElement.trigger('change');
        });

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

        $(document).on('click', '#button-create-author', function (e) {
            $('#modal-create-author .modal-header').before('<span id="span-loading" style="position: absolute; height: 100%; width: 100%; z-index: 99; background: #3c8dbc; opacity: 0.4;"><i class="fa fa-spinner fa-spin" style="font-size: 10em !important;margin-left: 35%;margin-top: 8%;"></i></span>');

            $.ajax({
                url: '{{ url("modals/author") }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                type: 'POST',
                dataType: 'JSON',
                data: $("#form-create-author").serialize(),
                beforeSend: function () {
                    $(".form-group").removeClass("has-error");
                    $(".help-block").remove();
                },
                complete: function () {
                    $('#button-create-author').button('reset');
                },
                success: function (json) {
                    var data = json['data'];

                    $('#span-loading').remove();

                    $('#modal-create-author').modal('hide');

                    $("#author_id").append('<option value="' + data.id + '" selected="selected">' + data.last_name + ', ' + data.first_name + '</option>');
                    $('#author_id').trigger('change');
                    $("#author_id").select2('refresh');
                },
                error: function (error, textStatus, errorThrown) {
                    $('#span-loading').remove();

                    if (error.responseJSON.errors.first_name) {
                        $("#modal-create-author input[name='first_name']").parent().parent().addClass('has-error');
                        $("#modal-create-author input[name='first_name']").parent().after('<p class="help-block">' + error.responseJSON.errors.first_name + '</p>');
                    }

                    if (error.responseJSON.errors.last_name) {
                        $("#modal-create-author input[name='last_name']").parent().parent().addClass('has-error');
                        $("#modal-create-author input[name='last_name']").parent().after('<p class="help-block">' + error.responseJSON.errors.last_name + '</p>');
                    }

                    if (error.responseJSON.errors.code) {
                        $("#modal-create-author input[name='code']").parent().parent().addClass('has-error');
                        $("#modal-create-author input[name='code']").parent().after('<p class="help-block">' + error.responseJSON.errors.code + '</p>');
                    }

                    if (error.responseJSON.errors.birthday) {
                        $("#modal-create-author input[name='birthday']").parent().parent().addClass('has-error');
                        $("#modal-create-author input[name='birthday']").parent().after('<p class="help-block">' + error.responseJSON.errors.birthday + '</p>');
                    }

                    if (error.responseJSON.errors.description) {
                        $("#modal-create-author input[name='description']").parent().parent().addClass('has-error');
                        $("#modal-create-author input[name='description']").parent().after('<p class="help-block">' + error.responseJSON.errors.description + '</p>');
                    }
                }
            });
        });
    });
</script>
