@extends('layout.default')

@section('title', trans('general.title.details', ['type' => trans_choice('general.members', 1)]) . ' | ' . $member->getName())
@section('header', trans('general.title.details', ['type' => trans_choice('general.members', 1)]))
@section('description', $member->getName())
@section('breadcrumb')
    <li><a href="{{ url('administration/members') }}">{{ trans_choice('general.members', 2) }}</a></li>
    <li class="active">{{ trans('general.title.details', ['type' => trans_choice('general.members', 1)]) }}</li>
@endsection

@section('content')
    <div class="row">
        <!-- Default box -->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <p class="lead">{{ $member->getName() }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th style="width:50%">{{ trans('general.name') }}</th>
                                        <td>{{ $member->getNameWithSalutation() }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{ trans('general.subscription_nr') }}</th>
                                        <td>{{ $member->code }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{ trans('general.email') }}</th>
                                        <td>
                                            <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%">{{ trans('general.comment') }}</th>
                                        <td>{{ $member->comment ?? '-' }}</td>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <a href="{{ route('members.activate', ['member' => $member]) }}" class="btn btn-success pull-right" style="margin-left: 5px"><span class="fa fa-upload"></span> &nbsp;{{ trans('general.activate_account') }}</a>
                            </div>

                            <div class="form-group no-margin">
                                <a href="{{ url('administration/members/' . $member->id . '/edit') }}" class="btn btn-default pull-right"><span class="fa fa-pencil"></span> &nbsp;{{ trans('general.edit') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @include('partials.info-box.lended')

            @include('partials.info-box.reservations')
        </div>
    </div>

    <div class="col-md-12 no-padding" style="padding-left: 10px">
        <h3>{{ trans_choice('general.invoices', 2) }}</h3>

        <div class="box box-primary">
            <div class="box-body">
                <!-- Facturen -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
