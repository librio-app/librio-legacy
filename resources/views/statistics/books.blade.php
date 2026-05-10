@extends('layout.default')

@section('title', trans_choice('general.statistics', 2) . ' ' .  trans_choice('general.books', 2))
@section('header', trans_choice('general.statistics', 2) . ' ' .  trans_choice('general.books', 2))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.statistics', 2) }} {{ trans_choice('general.books', 2) }}</li>
@endsection

@section('content')

    <div class="row">
        {!! Form::open(['url' => 'statistics/books', 'role' => 'form', 'method' => 'GET']) !!}
        <div class="col-md-1">
            <div class="form-group">
                <select name="year" class="form-control">
                    @foreach($years as $selectYear)
                        <option @if ($selectYear->year == $year) {{ 'selected="selected"' }} @endif value="{{ $selectYear->year }}" >{{ $selectYear->year }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <select name="month" class="form-control">
                    @foreach($months as $key => $selectMonth)
                        <option @if ($key == $month) {{ 'selected="selected"' }} @endif value="{{ $key }}" >{{ $selectMonth }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                {!! Form::button('<span class="fa fa-filter"></span> &nbsp;' . trans('general.filter'), ['type' => 'submit', 'class' => 'btn btn-sm btn-default btn-filter']) !!}
            </div>
        </div>

        <div class="col-md-2 pull-right text-right">
            <div class="form-group">
                {!! Form::button('<span class="fa fa-download"></span> &nbsp;' . trans('general.download'), ['id' => 'download-barcodes-statistics', 'type' => 'button', 'class' => 'btn btn-sm btn-danger']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <p class="lead">{{ trans('general.lended_books') }} {{ strtolower(trans('general.yearly')) }}</p>
                    <div id="lended-year" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <p class="lead">{{ trans('general.lended_books') }} {{ strtolower(trans('general.monthly')) }}</p>
                    <div id="lended-month" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
@stop


@push('scripts')
    <script type="text/javascript">
        const chart1 = new Chartisan({
            el: '#lended-year',
            url: '<?php echo url('statistics/year') . '?year=' . $year ?>',
            hooks: new ChartisanHooks()
                .beginAtZero()
                .colors(['#6191cf'])
        });

        const chart2 = new Chartisan({
            el: '#lended-month',
            url: '<?php echo url('statistics/month') . '?year=' . $year ?>' + '&month=' + '<?php echo $month ?>',
            hooks: new ChartisanHooks()
                .beginAtZero()
                .colors(['#6191cf'])
        });

        $('#download-barcodes-statistics').on('click', function() {
            window.open('<?php echo route('statistics.books.download') ?>', '_blank');
        });
    </script>
@endpush
