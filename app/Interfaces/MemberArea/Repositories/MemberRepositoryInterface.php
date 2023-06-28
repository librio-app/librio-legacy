<?php

namespace App\Interfaces\MemberArea\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Administration\Member;

interface MemberRepositoryInterface extends BaseRepositoryInterface
{
    public function find(int $id): ?Member;
    public function findByConfirmationCode(string $confirmationCode): ?Member;
}
