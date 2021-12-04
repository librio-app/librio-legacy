<div class="info-box">
    <span class="info-box-icon bg-red"><i class="fa fa-calendar-o"></i></span>

    <div class="info-box-content">
        @include('partials.info-box.total-reservations', ['reservations' => $reservations, 'notAvailableReservations' => $notAvailableReservations])
        <span class="info-box-text">{{ trans_choice('general.reservations', 2) }}</span>

        @if (!isset($link) || $link === true)
            <span class="progress-description">
                <a href="{{ url('member/lend/' . $member->id ) }}">{{ trans('general.more_info') }}</a>
            </span>
        @endif
    </div>
</div>
