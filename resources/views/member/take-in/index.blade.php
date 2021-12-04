@extends('layout.default')

@section('title', trans_choice('general.take-in', 2))
@section('header', trans_choice('general.take-in', 2))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="alerts"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body">
                    {!! Form::open(['url' => 'member/take-in', 'role' => 'form', 'method' => 'GET', 'id' => 'take-in']) !!}

                    <div class="form-group col-md-12 {{ $errors->has('barcode') ? 'has-error' : '' }}">
                        <label for="take-in" class="control-label">{{ trans('general.take-in') }}</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input autocomplete="off" autofocus class="form-control" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('general.barcodes', 1)]) }}" name="barcode" type="text" id="barcode" value="{{ $barcode ?? '' }}">
                            <input hidden="hidden" name="member_id" type="text" id="member_id" value="">

                            <span class="input-group-btn">
                                <button id="take-in-submit" type="submit" class="btn btn-success" data-loading-text="{{ trans('general.loading') }}"><span class="fa fa-save"></span> &nbsp;{{ trans('general.search') }}</button>
                            </span>
                        </div>

                        @include('partials.snippets.shortcut')

                        {!! $errors->first('barcode', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('partials.info-box.lend')
        </div>
    </div>

    <div id="replace"></div>
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#take-in').submit(function(e) {
                e.preventDefault();
                var btn = $("#take-in-submit");
                var original = btn.html();

                $.ajax({
                    url: '{{ url('member/take-in/') }}',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    type: 'POST',
                    data: $(this).serializeArray(),
                    dataType: 'JSON',
                    beforeSend: function () {
                        $(".form-group").removeClass("has-error");
                        $(".help-block").remove();
                        btn.html('<i class="fa fa-spinner fa-spin"></i> ' + btn.data("loading-text"));
                    },
                    success: function(json, status, xhr) {
                        var redirect = xhr.getResponseHeader("{{ \App\Http\Middleware\ShortCut::SHORT_CUT_HEADER }}");
                        if (redirect !== null) {
                            window.location.href = redirect;
                            return;
                        }

                        $('#span-loading').remove();
                        $("#barcode").val("");

                        if (json['success']) {
                            $('#replace').replaceWith(json['html']);
                            $('#member_id').attr('value', json['memberId']);
                        }

                        // add alerts
                        if (json['reservation']) {
                            $('#alerts').append(json['reservationHtml']);
                        }

                        if (json['themes']) {
                            $('#alerts').append(json['themesHtml']);
                        }

                        btn.html(original);
                    },
                    error: function (error, textStatus, errorThrown) {
                        var redirect = error.getResponseHeader("{{ \App\Http\Middleware\ShortCut::SHORT_CUT_HEADER }}");
                        if (redirect !== null) {
                            window.location.href = redirect;
                            return;
                        }

                        $('#span-loading').remove();
                        $("#barcode").val("");

                        if (error.responseJSON.errors.barcode) {
                            $("#take-in input[name='barcode']").parent().parent().addClass('has-error');
                            $("#take-in input[name='barcode']").parent().after('<p class="help-block">' + error.responseJSON.errors.barcode[0] + '</p>');
                            $("#alerts").after('<div class="alert alert-danger" role="alert">' + error.responseJSON.errors.barcode[0] + '<button type="button"class="close" data-dismiss="alert" aria-hidden="true" >&times;</button></div>');
                        }

                        btn.html(original);
                    }
                });
            });
        });
    </script>
@endpush
