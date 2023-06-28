<?php

namespace App\Interfaces\MemberArea\Services;

use App\Models\Administration\Member;

interface MemberServiceInterface
{
    public function getMemberById(int $id): Member;
    public function getMemberByConformationCode(string $confirmationCode): ?Member;

}
