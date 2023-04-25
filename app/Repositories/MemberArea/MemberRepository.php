<?php

namespace App\Repositories\MemberArea;

use App\Interfaces\MemberArea\Repositories\MemberRepositoryInterface;
use App\Models\Administration\Member;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class MemberRepository extends BaseRepository implements MemberRepositoryInterface
{
    public function __construct(Member $model)
    {
        parent::__construct($model);
    }

    public function find(int $id): ?Member
    {
        return parent::find($id);
    }

    public function findByConfirmationCode(string $confirmationCode): ?Member
    {
        return $this->model->firstWhere([
            ['enabled', '=', 1],
            ['confirmation_key', '=', $confirmationCode],
            ['confirmation_key_send_at', '>', Carbon::now()->addWeeks(1)]
        ]);
    }
}
