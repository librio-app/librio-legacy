@extends('layout.opac')

@section('title', trans('general.opac'))
@section('header', trans('general.opac'))
@section('breadcrumb')
    <li class="active">{{ trans('general.opac') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    {!! Form::open(['url' => 'opac/search', 'role' => 'form', 'method' => 'GET', 'id' => 'opac']) !!}

                    <div class="form-group col-md-12 {{ $errors->has('search') ? 'has-error' : '' }}">
                        <label for="search" class="control-label">{{ trans('general.search') }}</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input autofocus class="form-control" placeholder="{{ trans('general.form.enter', ['field' => strtolower(trans_choice('general.search_suggestion', 1))]) }}" name="search" type="text" id="search"  value="{{ $search ?? '' }}">
                        </div>

                        {!! $errors->first('barcode', '<p class="help-block">:message</p>') !!}
                    </div>

                    {{ Form::textGroup('barcode', trans_choice('general.barcodes', 1), 'barcode', []) }}

                    {{ Form::selectGroup('author', trans_choice('general.authors', 1), 'users', $authors, null, []) }}

                    {{ Form::selectGroup('category', trans_choice('general.categories', 1), 'users', $categories, null, []) }}

                    {{ Form::selectGroup('themes', trans_choice('general.themes', 2), 'users', $themes, null, ['multiple' => 'multiple']) }}

                    {{ Form::radioGroup('lended', trans('barcode.lended'), false, trans('general.yes'), trans('general.no'), ['reset' => true], 'col-md-3') }}

                    {{ Form::radioGroup('series', trans_choice('general.series', 1), false, trans('general.yes'), trans('general.no'), ['reset' => true], 'col-md-3') }}

                    <div class="form-group col-md-12 no-margin">
                        <a href="{{ url('opac/search') }}" class="btn btn-primary pull-left"><span class="fa fa-list"></span> &nbsp;{{ trans('general.show_all') }}</a>
                        <button type="submit" class="btn btn-success button-submit pull-right" data-loading-text="{{ trans('general.loading') }}"><span class="fa fa-search"></span> &nbsp;{{ trans('general.search') }}</button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

{{--    <h3>{{ trans_choice('general.featured', 2) }}</h3>--}}

{{--    <div class="row">--}}

{{--    </div>--}}
@stop

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function() {
            $("#author").select2({
                language: {
                    noResults: function () {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.authors', 1)]) }}",
                allowClear: true
            });

            $("#category").select2({
                language: {
                    noResults: function () {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.categories', 1)]) }}",
                allowClear: true
            });

            $("#themes").select2({
                language: {
                    noResults: function () {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.themes', 1)]) }}"
            });

            // on first focus (bubbles up to document), open the menu
            $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
                $(e.target).data("select2").$selection.one('focus focusin', function (e) {
                    e.stopPropagation();
                });
            });
        });
    </script>
@endpush
