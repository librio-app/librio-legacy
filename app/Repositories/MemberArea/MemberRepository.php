<?php

namespace App\Repositories\MemberArea;

use App\Interfaces\MemberArea\Repositories\MemberRepositoryInterface;
use App\Models\Administration\Member;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

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
        $member = $this->model->where('confirmation_key', '=', $confirmationCode)->get();

        if ($member)
        {
            return $member;
        }

        return null;
    }
}
