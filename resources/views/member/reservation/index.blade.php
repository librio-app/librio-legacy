@extends('layout.default')

@section('title', trans_choice('general.reservations', 2))
@section('header', trans_choice('general.reservations', 2))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.reservations', 2) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'member/reservations', 'role' => 'form', 'method' => 'GET']) !!}
            <div class="pull-left">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
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
                        <th class="col-md-2">{{ trans_choice('general.barcodes', 1) }}</th>
                        <th class="col-md-2">{{ trans('general.name') }}</th>
                        <th class="col-md-2">{{ trans_choice('general.created_date', 1) }}</th>
                        <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reservations as $item)
                        <?php $book = $item->barcode->book ?>
                        <tr>
                            <td>
                                <a href="{{ url('catalog/books/' . $book->id . '/details') }}">
                                    {{ $book->title }}
                                </a>
                            </td>
                            <td class="barcode">
                                {{ $item->barcode->barcode }}
                            </td>
                            <td>
                                <a href="{{ url('/member/lend/' . $item->member->id) }}">
                                    {{ $item->member->getNameWithSalutation() }}
                                </a>
                            </td>
                            <td>
                                {{ $item->created_at->format('d-m-Y') }} ({{ $item->created_at->diffForHumans() }})
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @permission('delete-member-reservations')
                                        <li class="divider"></li>
                                        <li>{!! Form::deleteLink($item, 'member/reserve', 'reservations', 'barcode') !!}</li>
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
        <!-- /.box-body -->
        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $reservations, 'type' => 'reservations'])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@stop
