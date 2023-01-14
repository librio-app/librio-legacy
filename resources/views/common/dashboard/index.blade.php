@extends('layout.default')

@section('title', trans('general.dashboard'))
@section('header', trans('general.dashboard'))

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('partials.info-box.take-in')
        </div>

        <div class="col-md-3">
            @include('partials.info-box.lend')
        </div>

        <div class="col-md-3">
            @include('partials.info-box.members')
        </div>

        <div class="col-md-3">
            @include('partials.info-box.statistics')
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <p class="lead">{{ trans_choice('general.notes', 2) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ trans('general.title.default') }}</th>
                                    <th>{{ trans_choice('general.notes', 1) }}</th>
                                    <th>{{ trans('general.date') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($notes as $note)
                                <tr>
                                    <td style="width:20%; font-weight: bold">{{ $note->title }}</th>
                                    <td style="width:60%">{{ $note->text }}</td>
                                    <td style="width:20%">{{ $note->getNotitieDatum() }}</td>
                                    <td style="width:10%">
                                        {!! Form::deleteLink($note, 'common/notes', '', 'title') !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            {!! Form::open(['url' => 'common/notes', 'role' => 'form']) !!}

                {{ Form::textGroup('title', trans('general.title.default'), 'bookmark', []) }}

                {{ Form::textGroup('text', trans_choice('general.notes', 1), 'pencil', []) }}

                {{ Form::saveButtons('common/notes') }}

            {!! Form::close() !!}
        </div>
    </div>
@stop
