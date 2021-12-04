<span id="total-lended" class="info-box-number">
    {{ count($lended ?? 0) }} /
    {{ isset($subscription) ? ($subscription->book_limit == 0 ? strtolower(trans('general.unlimited')) : $subscription->book_limit) : strtolower(trans('general.no_subscription')) }}
    {{ isset($subscription) ? '(' . $subscription->name . ')' : '' }}
</span>
