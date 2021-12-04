<div class="modal fade in" id="modal-create-category" style="display: block;">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('general.title.new', ['type' => trans_choice('general.categories', 1)]) }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'form-create-category', 'role' => 'form']) !!}

                <div class="box-body">
                    {{ Form::textGroup('name', trans('general.name'), 'bookmark') }}

                    {{ Form::textGroup('code', trans('general.code'), 'key') }}

                    {{ Form::textareaGroup('description', trans('general.description')) }}

                    {!! Form::hidden('enabled', '1', []) !!}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'button', 'id' =>'button-create-category', 'class' => 'btn btn-success button-submit', 'data-loading-text' => trans('general.loading')]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-create-category').modal('show');

        let nameElement = $("#modal-create-category #name");
        let codeElement = $("#modal-create-category #code");

        nameElement.on("change paste keyup", function () {
            codeElement.val(nameElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
            codeElement.trigger('change');
        });

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

        $(document).on('click', '#button-create-category', function (e) {
            $('#modal-create-category .modal-header').before('<span id="span-loading" style="position: absolute; height: 100%; width: 100%; z-index: 99; background: #3c8dbc; opacity: 0.4;"><i class="fa fa-spinner fa-spin" style="font-size: 10em !important;margin-left: 35%;margin-top: 8%;"></i></span>');

            $.ajax({
                url: '{{ url("modals/category") }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                type: 'POST',
                dataType: 'JSON',
                data: $("#form-create-category").serialize(),
                beforeSend: function () {
                    $(".form-group").removeClass("has-error");
                    $(".help-block").remove();
                },
                complete: function () {
                    $('#button-create-category').button('reset');
                },
                success: function (json) {
                    var data = json['data'];

                    $('#span-loading').remove();

                    $('#modal-create-category').modal('hide');

                    $("#category_id").append('<option value="' + data.id + '" selected="selected">' + data.name + '</option>');
                    $('#category_id').trigger('change');
                    $("#category_id").select2('refresh');
                },
                error: function (error, textStatus, errorThrown) {
                    $('#span-loading').remove();

                    if (error.responseJSON.errors.name) {
                        $("#modal-create-category input[name='name']").parent().parent().addClass('has-error');
                        $("#modal-create-category input[name='name']").parent().after('<p class="help-block">' + error.responseJSON.errors.name + '</p>');
                    }

                    if (error.responseJSON.errors.code) {
                        $("#modal-create-category input[name='code']").parent().parent().addClass('has-error');
                        $("#modal-create-category input[name='code']").parent().after('<p class="help-block">' + error.responseJSON.errors.code + '</p>');
                    }

                    if (error.responseJSON.errors.description) {
                        $("#modal-create-category input[name='description']").parent().parent().addClass('has-error');
                        $("#modal-create-category input[name='description']").parent().after('<p class="help-block">' + error.responseJSON.errors.description + '</p>');
                    }
                }
            });
        });
    });
</script>
