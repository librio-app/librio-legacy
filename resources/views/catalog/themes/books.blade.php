<div class="box box-primary">
    <div class="box-body">
        <div class="table table-responsive">
            <table class="table table-striped table-hover" id="tbl-books">
                <thead>
                <tr>
                    <th class="col-md-2">{{ trans('general.title.default') }}</th>
                    <th class="col-md-1">{{ trans_choice('general.categories', 1) }}</th>
                    <th class="col-md-1">{{ trans('general.code') }}</th>
                    <th class="col-md-2">{{ trans_choice('general.authors', 1) }}</th>
                    <th class="col-md-1 hidden-xs">{{ trans_choice('general.statuses', 1) }}</th>
                    <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
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
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->author->getName() }}</td>
                        <td>
                            @if ($item->enabled)
                                <span class="label label-success">{{ trans('general.enabled') }}</span>
                            @else
                                <span class="label label-danger">{{ trans('general.disabled') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>{!! Form::deleteLink($item, 'catalog/themes/' . $theme->id . '/remove/book', 'books', 'title') !!}</li>
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
