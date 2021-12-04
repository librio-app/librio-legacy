@extends('layout.default')

@section('title', trans('general.lend_history') . ' ' . $member->getNameWithSalutation())
@section('header', trans('general.lend_history') . ' ' . $member->getNameWithSalutation())
@section('breadcrumb')
    <li><a href="{{ url('member/lend/' . $member->id) }}">{{ trans('general.lend') }}</a></li>
    <li>{{ $member->getName() }}</li>
@endsection

@section('new_button')
    <span class="new-button"><a href="{{ url('member/lend/' . $member->id ) }}" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left"></span> {{ trans('general.lend') }}:&nbsp;{{ $member->getName() }}</a></span>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'member/history/'.  $member->id, 'role' => 'form', 'method' => 'GET']) !!}
            <div id="items" class="pull-left box-filter">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
                {!! Form::text('barcode', request('barcode'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans_choice('general.barcodes', 1)]) !!}
                {!! Form::select('authors[]', $authors, request('authors'), ['id' => 'filter-authors', 'class' => 'form-control input-filter input-lg', 'multiple' => 'multiple']) !!}
                {!! Form::button('<span class="fa fa-filter"></span> &nbsp;' . trans('general.filter'), ['type' => 'submit', 'class' => 'btn btn-sm btn-default btn-filter']) !!}
            </div>
            <div class="pull-right">
                <span class="title-filter hidden-xs">{{ trans('general.show') }}:</span>
                {!! Form::select('limit', $limits, request('limit', 25), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-reservations">
                    <thead>
                    <tr>
                        <th class="col-md-2">{{ trans('general.title.default') }}</th>
                        <th class="col-md-2">{{ trans_choice('general.authors', 1) }}</th>
                        <th class="col-md-2">{{ trans_choice('general.barcodes', 1) }}</th>
                        <th class="col-md-2">{{ trans_choice('general.lend_at', 1) }}</th>
                        <th class="col-md-2">{{ trans_choice('general.taken_in_at', 1) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($history as $item)
                        @php $book = $item->barcode->book @endphp
                        <tr>
                            <td>
                                <a href="{{ url('catalog/books/' . $book->id . '/details') }}">
                                    {{ $book->title }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('catalog/authors/' . $book->author->id . '/details') }}">
                                    {{ $book->author->getName() }}
                                </a>
                            </td>
                            <td class="barcode">
                                {{ $item->barcode->barcode }}
                            </td>
                            <td>
                                {{ $item->lend_at->format('d-m-Y') }} ({{ $item->lend_at->diffForHumans() }})
                            </td>
                            <td>
                                @if ($item->take_in_at !== null)
                                    {{ $item->take_in_at->format('d-m-Y') }} ({{ $item->take_in_at->diffForHumans() }})
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $history, 'type' => 'books'])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@stop

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#filter-authors").select2({
                placeholder: "{{ trans('general.form.select.field', ['field' => trans_choice('general.authors', 1)]) }}"
            });
        });
    </script>
@endpush
