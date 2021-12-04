@permission('read-statistics-panel')
    <a href="{{ url('statistics/books') }}" class="info-box">
        <span class="info-box-icon bg-blue"><i class="fa fa-bar-chart"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">{{ trans_choice('general.statistics', 2) }}</span>
        </div>
    </a>
@endpermission
