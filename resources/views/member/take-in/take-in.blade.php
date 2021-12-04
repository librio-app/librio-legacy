<div id="replace">
    <h3>{{ trans('general.lended_books') }}</h3>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-body">
                    @include('member.lend.books', ['lended' => $lended])
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
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
                                        <td><a href="{{ url('member/lend/' . $member->id) }}">{{ $member->getName() }}</a></td>
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
    </div>
</div>
