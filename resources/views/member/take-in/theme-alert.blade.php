<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i>{{ trans('general.themes_found') }}</h4>
    {{ trans('general.themes_text', ['themeNames' =>  ': ' . $themeNames, 'title' => $book->title, 'barcode' => $barcode->barcode]) }}
</div>
