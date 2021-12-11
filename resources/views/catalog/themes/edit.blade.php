@extends('layout.default')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.themes', 1)]))
@section('header', trans('general.title.edit', ['type' => trans_choice('general.themes', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.themes', 2) }}</li>
@endsection

@section('new_button')
    <span class="new-button"><a href="{{ url('catalog/themes/' . $theme->id . '/add/books') }}" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_books') }}</a></span>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::model($theme, [
            'method' => 'PATCH',
            'url' => ['catalog/themes', $theme->id],
            'role' => 'form',
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('name', trans('general.name'), 'bookmark') }}

            {{ Form::radioGroup('active', trans('general.active')) }}

            {{ Form::dateRange('start_at', trans('general.start_at'), 'calendar') }}

            {{ Form::dateRange('end_at', trans('general.end_at'), 'calendar') }}
        </div>
        <!-- /.box-body -->

        @permission('update-catalog-themes')
        <div class="box-footer">
            {{ Form::saveButtons('catalog/themes') }}
        </div>
        <!-- /.box-footer -->
        @endpermission

        {!! Form::close() !!}
    </div>

    <h3>{{ trans_choice('general.books', 2) }}</h3>

    @include('catalog.themes.books', ['books' => $books, 'theme' => $theme])
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endpush
