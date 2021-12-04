<div class="modal fade in" id="modal-create-theme" style="display: block;">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('general.title.new', ['type' => trans_choice('general.themes', 1)]) }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'form-create-theme', 'role' => 'form']) !!}

                <div class="box-body">
                    {{ Form::textGroup('name', trans('general.name'), 'bookmark') }}

                    {!! Form::hidden('active', '0', []) !!}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {!! Form::button('<span class="fa fa-save"></span> &nbsp;' . trans('general.save'), ['type' => 'button', 'id' =>'button-create-theme', 'class' => 'btn btn-success button-submit', 'data-loading-text' => trans('general.loading')]) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.cancel') }}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#modal-create-theme').modal('show');

        $(document).on('click', '#button-create-theme', function (e) {
            $('#modal-create-theme .modal-header').before('<span id="span-loading" style="position: absolute; height: 100%; width: 100%; z-index: 99; background: #3c8dbc; opacity: 0.4;"><i class="fa fa-spinner fa-spin" style="font-size: 10em !important;margin-left: 35%;margin-top: 8%;"></i></span>');

            $.ajax({
                url: '{{ url("modals/theme") }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                type: 'POST',
                dataType: 'JSON',
                data: $("#form-create-theme").serialize(),
                beforeSend: function () {
                    $(".form-group").removeClass("has-error");
                    $(".help-block").remove();
                },
                complete: function () {
                    $('#button-create-theme').button('reset');
                },
                success: function (json) {
                    var data = json['data'];

                    $('#span-loading').remove();

                    $('#modal-create-theme').modal('hide');

                    $("#themes").append('<option value="' + data.id + '" selected="selected">' + data.name + '</option>');
                    $('#themes').trigger('change');
                    $("#themes").select2('refresh');
                },
                error: function (error, textStatus, errorThrown) {
                    $('#span-loading').remove();

                    if (error.responseJSON.errors.name) {
                        $("#modal-create-theme input[name='name']").parent().parent().addClass('has-error');
                        $("#modal-create-theme input[name='name']").parent().after('<p class="help-block">' + error.responseJSON.errors.name + '</p>');
                    }
                }
            });
        });
    });
</script>
