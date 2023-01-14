<div class="info-box">
    <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>

    @if($subscription && $member)
        <div class="info-box-content">
            @include('partials.info-box.total-lended', ['subscription' => $subscription, 'lended' => $lended])
            <span class="info-box-text">{{ trans('general.lended_books') }}</span>

            <div class="progress">
                @if ($subscription->book_limit !== 0)
                    <div class="progress-bar" style="width: {{ round((count($lended) ?? 0) * 100 / $subscription->book_limit) }}%; background: #155317"></div>
                @endif
            </div>

            @if (!isset($link) || $link === true)
                <span class="progress-description">
                    <a href="{{ url('member/lend/' . $member->id ) }}">{{ trans('general.to_lended') }}</a>
                </span>
            @endif
        </div>
    @else
        <div class="info-box-content">
            @include('partials.info-box.total-lended', ['lended' => $lended])
            <span class="info-box-text">{{ trans('general.lended_books') }}</span>

            @if (!isset($link) || $link === true)
                <span class="progress-description">
                    <a href="{{ url('member/lend/' . $member->id ) }}">{{ trans('general.to_lended') }}</a>
                </span>
            @endif
        </div>
    @endif
</div>
