@extends('layout.default')

@section('title', trans_choice('general.lend', 2))
@section('header', trans_choice('general.lend', 2))
@section('breadcrumb')
    <li><a href="{{ url('member/lend') }}">{{ trans('general.lend') }}</a></li>
    <li>{{ $member->getName() }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="alerts"></div>
        </div>
    </div>

    @if($subscriptionIsEnding)
        <div class="row" id="reservation-alert">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i>{{ trans('general.subscription_warning') }}</h4>
                    {{ trans('general.subscription_expiring') }}
                </div>
            </div>
        </div>
    @endif

    @if(count($reservations) - count($notAvailableReservations) > 0)
        <div class="row" id="reservation-alert">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i>{{ trans('general.reservation_found') }}</h4>
                    {{ trans('general.reservation_simple') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <p class="lead">{{ $member->getNameWithSalutation() }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th style="width:50%">{{ trans('general.name') }}</th>
                                        <td><a href="{{ url('administration/members/' . $member->id . '/details') }}">{{ $member->getNameWithSalutation() }}</a></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{ trans('general.subscription_nr') }}</th>
                                        <td>{{ $member->code }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{ trans('general.address_line_1') }}</th>
                                        <td>{{ $member->address_line_1 }}</td>
                                    </tr>
                                    @if($member->address_line_2)
                                        <tr>
                                            <th style="width:50%">{{ trans('general.address_line_2') }}</th>
                                            <td>{{ $member->address_line_2 }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th style="width:50%">{{ trans('general.zipcode') }}</th>
                                        <td>{{ $member->zipcode }}</td>
                                    </tr>
                                    @if($member->state)
                                        <tr>
                                            <th style="width:50%">{{ trans('general.state') }}</th>
                                            <td>{{ $member->state }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th style="width:50%">{{ trans('general.city') }}</th>
                                        <td>{{ $member->city }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @include('partials.info-box.lended', ['link' => false])

            @include('partials.info-box.reservations', ['link' => false])

            @if($costs > 0)
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-number">{{ trans('general.to_pay') }}: @money($costs * 100, (isset($subscription) ? $subscription->currency : 'EUR'))</span>
                        <span class="info-box-text">
                            <a href="{{ url('member/pay/' . $member->id ) }}">{{ trans('general.pay') }}</a>
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    {!! Form::open(['url' => 'member/lend/' .  $member->id . '/', 'role' => 'form', 'method' => 'POST', 'id' => 'lend']) !!}

                    <div class="form-group col-md-12 {{ $errors->has('barcode') ? 'has-error' : '' }}">
                        <label for="lend" class="control-label">{{ trans_choice('general.lend', 2) }}</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input hidden="hidden" name="member_id" type="text" id="member" value="{{ $member->id }}">
                            <input autocomplete="off" autofocus class="form-control" {{ (!isset($subscription)) ? 'disabled="disabled"' : '' }} placeholder="{{ trans('general.form.enter', ['field' => trans_choice('general.barcodes', 1)]) }}" name="barcode" type="text" id="barcode">

                            <span class="input-group-btn">
                                <button id="lend-submit" type="submit" class="btn btn-success" data-loading-text="{{ trans('general.loading') }}" {{ (!isset($subscription)) ? 'disabled="disabled"' : '' }}><span class="fa fa-save"></span> &nbsp;{{ trans('general.add') }}</button>
                            </span>
                        </div>

                        @include('partials.snippets.shortcut')

                        {!! $errors->first('barcode', '<p class="help-block">:message</p>') !!}
                        {!! $errors->first('member_id', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-xs-6">
                    @include('partials.info-box.lend')
                </div>

                <div class="col-xs-6">
                    @include('partials.info-box.take-in')
                </div>
            </div>
        </div>
    </div>

    <div class="content-subheader">
        <h3>{{ trans('general.lended_books') }}</h3>

        <ol class="breadcrumb">
            @permission('read-member-history')
            <li><a href="{{ url('member/history/' . $member->id) }}"><i class="fa fa-history"></i> {{ trans('general.lend_history') }}</a></li>
            @endpermission
        </ol>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    @include('member.lend.books', ['lended' => $lended])
                </div>
            </div>
        </div>
    </div>

    <h3>{{ trans_choice('general.reservations', 2) }}</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table table-responsive">
                        @include('member.lend.reservations', ['reservations' => $reservations])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    {!! Form::open(['url' => 'member/reserve/' .  $member->id . '/', 'role' => 'form', 'method' => 'POST', 'id' => 'reserve']) !!}

                    <div class="form-group col-md-12 {{ $errors->has('reservation') ? 'has-error' : '' }}">
                        <label for="lend" class="control-label">{{ trans_choice('general.reservations', 1) }}</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input hidden="hidden" name="member_id" type="text" id="member" value="{{ $member->id }}">
                            <input autofocus class="form-control barcode" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('general.barcodes', 1)]) }}" name="reservation" type="text" id="reservation">

                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success button-submit"><span class="fa fa-save"></span> &nbsp;{{ trans('general.add') }}</button>
                            </span>
                        </div>

                        {!! $errors->first('reservation', '<p class="help-block">:message</p>') !!}
                        {!! $errors->first('member_id', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#lend').submit(function(e) {
                e.preventDefault();
                var btn = $("#lend-submit");
                var original = btn.html();

                $.ajax({
                    url: '{{ url('member/lend/' . $member->id . '/') }}',
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
                            $('#tbl-lended').replaceWith(json['lended']);
                            $('#tbl-reservations').replaceWith(json['reservations']);

                            if (json['total-lended'] !== null) {
                                $('#total-lended').replaceWith(json['total-lended']);
                            }

                            if (json['total-reservations'] !== null) {
                                $('#total-reservations').replaceWith(json['total-reservations']);
                            }

                            if (json['reservations-available']) {
                                $('#reservation-alert').hide();
                            }
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
                            $("#lend input[name='barcode']").parent().parent().addClass('has-error');
                            $("#lend input[name='barcode']").parent().after('<p class="help-block">' + error.responseJSON.errors.barcode[0] + '</p>');
                            $("#alerts").after('<div class="alert alert-danger" role="alert">' + error.responseJSON.errors.barcode[0] + '<button type="button"class="close" data-dismiss="alert" aria-hidden="true" >&times;</button></div>');
                        }

                        if (error.responseJSON.errors.member_id) {
                            $("#lend input[name='barcode']").parent().parent().addClass('has-error');
                            $("#lend input[name='barcode']").parent().after('<p class="help-block">' + error.responseJSON.errors.member_id[0] + '</p>');
                            $("#alerts").after('<div class="alert alert-danger" role="alert">' + error.responseJSON.errors.member_id[0] + '<button type="button"class="close" data-dismiss="alert" aria-hidden="true" >&times;</button></div>');
                        }

                        btn.html(original);
                    }
                });
            });
        });
    </script>
@endpush
