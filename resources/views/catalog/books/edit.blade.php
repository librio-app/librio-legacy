@extends('layout.default')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.books', 1)]))
@section('header', trans('general.title.edit', ['type' => trans_choice('general.books', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.books', 2) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::model($book, [
            'method' => 'PATCH',
            'url' => ['catalog/books', $book->id],
            'role' => 'form',
        ]) !!}

        <div class="box-body">
            {{ Form::textGroup('title', trans('general.title.default'), 'bookmark') }}

            {{ Form::textGroup('code', trans('general.code'), 'key', ['disabled' => !Auth::user()->hasRole('admin')]) }}

            {{ Form::selectGroup('series_id', trans_choice('general.series', 1), 'book', $series, null, ['add' => true]) }}

            {{ Form::numberGroup('series_nr', trans_choice('general.series_nr', 1), 'list-ol', []) }}

            {{ Form::textareaGroup('description', trans('general.description')) }}

            {{ Form::textGroup('isbn', trans('general.isbn'), 'barcode', []) }}

            {{ Form::textGroup('ean', trans('general.ean'), 'barcode', []) }}

            {{ Form::selectGroup('author_id', trans_choice('general.authors', 1), 'users', $authors, null, ['add' => true]) }}

            {{ Form::selectGroup('publisher_id', trans_choice('general.publishers', 1), 'industry', $publishers, null, ['add' => true]) }}

            {{ Form::selectGroup('category_id', trans_choice('general.categories', 1), 'list', $categories, null, ['add' => true]) }}

            {{ Form::selectGroup('type_id', trans_choice('general.types', 1), 'tint', $types, 1, ['add' => true]) }}

            {{ Form::selectGroup('themes', trans_choice('general.themes', 2), 'eyedropper', $themes, $selectedThemes, ['add' => true, 'multiple' => 'multiple']) }}

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-catalog-books')
        <div class="box-footer">
            {{ Form::saveButtons('catalog/books') }}
        </div>
        @endpermission

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            $("#author_id").select2({
                language: {
                    noResults: function() {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.authors', 1)]) }}"
            });

            $("#publisher_id").select2({
                language: {
                    noResults: function() {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.publishers', 1)]) }}"
            });

            $("#category_id").select2({
                language: {
                    noResults: function() {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.categories', 1)]) }}"
            });

            $("#type_id").select2({
                language: {
                    noResults: function() {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.types', 1)]) }}"
            });

            $("#themes").select2({
                language: {
                    noResults: function() {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.themes', 1)]) }}"
            });

            $("#series_id").select2({
                language: {
                    noResults: function() {
                        return "{{ trans('general.no_results') }}";
                    },
                },
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.series', 1)]) }}"
            }).on('select2:open', () => {
                $(".select2-results:not(:has(a))")
                    .append('<a href="#" id="empty" style="padding: 6px;height: 20px;display: inline-table;">{{ trans_choice('general.empty', 2) }}</a>');

                $('#empty').on('click', function (e) {
                    e.preventDefault();
                    $('#series_id').val(null).trigger('change');
                    $('#series_id').select2('close');
                });
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

            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            var codeElement = $("input[name='code']");
            var code = $("input[name='code']").val();
            var formElement = codeElement.parent().parent();
            codeElement.on("change paste keyup", function () {
                $.ajax({
                    url: '<?php echo url('api/catalog/books/codes') ?>',
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

            $(document).on('click', '#button-series', function (e) {
                $('#modal-create-series').remove();

                $.ajax({
                    url: '{{ url("modals/series/create") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(json) {
                        if (json['success']) {
                            $('body').append(json['html']);
                        }
                    }
                });
            });

            $(document).on('click', '#button-author', function (e) {
                $('#modal-create-author').remove();

                $.ajax({
                    url: '{{ url("modals/author/create") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(json) {
                        if (json['success']) {
                            $('body').append(json['html']);
                        }
                    }
                });
            });

            $(document).on('click', '#button-publisher', function (e) {
                $('#modal-create-publisher').remove();

                $.ajax({
                    url: '{{ url("modals/publisher/create") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(json) {
                        if (json['success']) {
                            $('body').append(json['html']);
                        }
                    }
                });
            });

            $(document).on('click', '#button-category', function (e) {
                $('#modal-create-category').remove();

                $.ajax({
                    url: '{{ url("modals/category/create") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(json) {
                        if (json['success']) {
                            $('body').append(json['html']);
                        }
                    }
                });
            });

            $(document).on('click', '#button-type', function (e) {
                $('#modal-create-type').remove();

                $.ajax({
                    url: '{{ url("modals/type/create") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(json) {
                        if (json['success']) {
                            $('body').append(json['html']);
                        }
                    }
                });
            });

            $(document).on('click', '#button-themes', function (e) {
                $('#modal-create-theme').remove();

                $.ajax({
                    url: '{{ url("modals/theme/create") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(json) {
                        if (json['success']) {
                            $('body').append(json['html']);
                        }
                    }
                });
            });
        });
    </script>
@endpush
