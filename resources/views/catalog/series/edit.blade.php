@extends('layout.default')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.series', 1)]))
@section('header', trans('general.title.edit', ['type' => trans_choice('general.series', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.series', 2) }}</li>
@endsection


@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::model($series, [
            'method' => 'PATCH',
            'url' => ['catalog/series', $series->id],
            'role' => 'form',
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('title', trans('general.name'), 'bookmark') }}

            {{ Form::textGroup('code', trans('general.code'), 'key', ['disabled' => !Auth::user()->hasRole('admin')]) }}
        </div>
        <!-- /.box-body -->

        @permission('update-catalog-series')
        <div class="box-footer">
            {{ Form::saveButtons('catalog/series') }}
        </div>
        <!-- /.box-footer -->
        @endpermission

        {!! Form::close() !!}
    </div>

    @if($books->count() > 0)

    <h3>{{ trans_choice('general.books', 2) }}</h3>

    <div class="box box-primary">
        <div class="box-body">
            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-books">
                    <thead>
                    <tr>
                        <th class="col-md-2">@sortablelink('series_nr', trans('general.title.default'))</th>
                        <th class="col-md-1">@sortablelink('series_nr', trans_choice('general.series_nr', 1))</th>
                        <th class="col-md-2">{{ trans_choice('general.authors', 1) }}</th>
                        <th class="col-md-1 text-right">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $item)
                        <tr>
                            <td>
                                <a href="{{ url('catalog/books/' . $item->id . '/edit') }}">
                                    {{ $item->title }}
                                </a>
                            </td>
                            <td>{{ $item->series_nr ?? '-' }}</td>
                            <td>{{ $item->author->getName() }}</td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ url('catalog/books/' . $item->id . '/edit') }}">{{ trans('general.edit') }}</a></li>
                                        @permission('delete-catalog-series')
                                        <li class="divider"></li>
                                        <li>{!! Form::deleteLink($item, 'catalog/series/books', 'books', 'title') !!}</li>
                                        @endpermission
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $books, 'type' => 'books'])
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            var titleElement = $("input[name='title']");
            var codeElement = $("input[name='code']");

            // titleElement.on("change paste keyup", function () {
            //     codeElement.val(titleElement.val().toLowerCase().replace(/[^a-z0-9]/gi,''));
            //     codeElement.trigger('change');
            // });

            var code = $("input[name='code']").val();
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
                    data: $("input[name='code']").val(),
                    success: function (data) {
                        codeElement.parent().parent().removeClass('has-error');
                        $(".help-block").remove();

                        if (data.duplicated && code !== data.code) {
                            formElement.addClass('has-error');

                            formElement.append('<p class="help-block">' + data.message + '</p>');
                        }
                    }
                });
            });
        });
    </script>
@endpush
