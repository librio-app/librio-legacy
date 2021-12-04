@if ($allowed && $item->status === 'lended')
    <button type="button" class="btn-xs btn-{!! Barcode::getLabel($item->status) !!} dropdown-toggle" data-toggle="dropdown"  aria-expanded="false">
        {{ trans('barcode.' . $item->status) }}
    </button>
    <ul class="dropdown-menu dropdown-menu-xl-right">
        @php
            $member = '';
            $lended = $item->lended()->first();
            if ($lended instanceof \App\Models\Member\Book) {
                $memberId =  $lended->member->id;
                $member = $lended->member->getName();
            }
        @endphp
        <li><a href="{{ url('member/lend/' . $memberId) }}">{{ $member }}</a></li>
    </ul>
@else
    <span class="label label-{!! Barcode::getLabel($item->status) !!}">{{ trans('barcode.' . $item->status) }}</span>
@endif
