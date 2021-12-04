<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembersExport implements FromQuery, WithHeadings
{
    /**
     * @var Builder
     */
    protected $query;

    use Exportable;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query
            ->select(['members.*', 'member_subscription.subscription_id', 'member_subscription.expire_date', 'subscriptions.name'])
            ->join('member_subscription', 'member_subscription.member_id', '=', 'members.id')
            ->join('subscriptions', 'subscriptions.id', '=', 'member_subscription.subscription_id')
            ->groupBy(['member_subscription.id'])
            ->toBase();
    }

    public function headings(): array
    {
        return [
            "id",
            "code",
            "first_name",
            "insertion",
            "last_name",
            "account",
            "email",
            "email_verified_at",
            "password",
            "birthday",
            "comment",
            "enabled",
            "locale",
            "address_line_1",
            "address_line_2",
            "zipcode",
            "state",
            "city",
            "remember_token",
            "created_at",
            "updated_at",
            "deleted_at",
            "salutation",
            "subscription_id",
            "expire_date",
            "name",
        ];
    }
}
