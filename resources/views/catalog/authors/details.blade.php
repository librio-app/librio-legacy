@extends('layout.default')

@section('title', trans('general.title.details', ['type' => trans_choice('general.authors', 1)]))
@section('header', trans('general.title.details', ['type' => trans_choice('general.authors', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.authors', 2) }}</li>
@endsection


@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <p class="lead">{{ $author->getNameAttribute() }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th style="width:50%">{{ trans('general.firstname') }}</th>
                                <td>{{ $author->first_name }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">{{ trans('general.lastname') }}</th>
                                <td>{{ $author->last_name }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">{{ trans('general.code') }}</th>
                                <td>{{ $author->code }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">{{ trans('general.birthday') }}</th>
                                <td>{{ $author->birthday  ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%;">{{ trans('general.enabled') }}</th>
                                <td style="color: <?php echo ($author->enabled) ? '#00a65a' : '#9f191f' ?>">{{ $author->enabled ? trans('general.yes') : trans('general.no') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xs-7">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>{{ trans_choice('general.created_date', 1) }}</th>
                                <td>{{ $author->created_at->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans_choice('general.updated_date', 1) }}</th>
                                <td>{{ $author->updated_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('general.description') }}</th>
                                <td>{{ mb_strimwidth($author->description ?? '-', 0, 400, '...') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @permission('create-catalog-authors')
                    <div class="form-group no-margin">
                        <a href="{{ route('authors.create') }}" class="btn btn-success pull-right" style="margin-left: 1rem"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a>
                    </div>
                    @endpermission
                    <div class="form-group no-margin">
                        <a href="{{ route('authors.edit', ['author' => $author])}}" class="btn btn-default pull-right"><span class="fa fa-pencil"></span> &nbsp;{{ trans('general.edit') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3>{{ trans_choice('general.books', 2) }}</h3>

    <div class="box box-primary">
        <div class="box-body">
            @include('partials.books.bookstable')
        </div>

        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $books, 'type' => 'books'])
        </div>
    </div>
@endsection
