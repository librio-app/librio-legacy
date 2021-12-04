@extends('layout.default')

@section('title', trans('general.quick_search'))
@section('header', trans('general.quick_search')  . (($search) ? ': \'' . $search . '\'' : ''))

@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <div class="col-xs-12">
                <p class="lead">{{ trans_choice('general.books', 2) }}</p>
            </div>

            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-books">
                    <thead>
                    <tr>
                        <th class="col-md-2">{{ trans('general.title.default') }}</th>
                        <th class="col-md-1">{{ trans_choice('general.series', 1) }}</th>
                        <th class="col-md-1">{{ trans_choice('general.categories', 1) }}</th>
                        <th class="col-md-2">{{ trans_choice('general.authors', 1) }}</th>
                        <th class="col-md-1 hidden-xs">{{ trans('general.active') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $item)
                        <tr>
                            <td>
                                <a href="{{ url('catalog/books/' . $item->id . '/details') }}">
                                    {{ $item->title }}
                                </a>
                            </td>
                            <td>{{ isset($item->series) ? $item->series->title : '-' }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->author->getName() }}</td>
                            <td>
                                @if ($item->enabled)
                                    <span class="label label-success">{{ trans('general.enabled') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('general.disabled') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="col-xs-12">
                <p class="lead">{{ trans_choice('general.members', 2) }}</p>
            </div>

            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-members">
                    <thead>
                    <tr>
                        <th class="col-md-2">{{ trans('general.name') }}</th>
                        <th class="col-md-1">{{ trans('general.subscription_nr') }}</th>
                        <th class="col-md-1">{{ trans('general.account') }}</th>
                        <th class="col-md-3">{{ trans('general.email') }}</th>
                        <th class="col-md-3">{{ trans('general.city') }}</th>
                        <th class="col-md-1">{{ trans('general.enabled') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $item)
                        <tr>
                            <td>
                                <a href="{{ url('member/lend/' . $item->id) }}">
                                    {{ $item->getNameWithSalutation() }}
                                </a>
                            </td>
                            <td>{{ $item->code }}</td>
                            <td style="color: <?php echo ($item->account) ? '#00a65a' : '#9f191f' ?>">
                                @if($item->account)
                                    {{ trans('general.yes') }}
                                @else
                                    {{ trans('general.no') }}
                                @endif
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->city }}</td>
                            <td>
                                @if ($item->enabled)
                                    <span class="label label-success">{{ trans('general.enabled') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('general.disabled') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
