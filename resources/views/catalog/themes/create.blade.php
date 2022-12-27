@extends('layout.default')

@section('title', trans('general.title.new', ['type' => trans_choice('general.themes', 1)]))
@section('header', trans('general.title.new', ['type' => trans_choice('general.themes', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.themes', 2) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::open(['url' => 'catalog/themes', 'role' => 'form']) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'bookmark', ['autofocus' => true]) }}

            {{ Form::radioGroup('active', trans('general.active'), true) }}

            {{ Form::dateRange('start_at', trans('general.start_at'), 'calendar') }}

            {{ Form::dateRange('end_at', trans('general.end_at'), 'calendar') }}
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            {{ Form::saveButtons('catalog/themes') }}
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            $('input[theme=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endpush
