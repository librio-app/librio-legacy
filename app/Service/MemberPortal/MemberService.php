<?php

namespace App\Service\MemberPortal;

use App\Interfaces\MemberArea\Repositories\MemberRepositoryInterface;
use App\Interfaces\MemberArea\Services\MemberServiceInterface;
use App\Models\Administration\Member;

class MemberService implements MemberServiceInterface
{
    private MemberRepositoryInterface $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getMemberByConformationCode(string $confirmationCode): ?Member
    {
        return $this->memberRepository->findByConformationCode($confirmationCode);
    }

    public function getMemberById(int $id): Member
    {
        // TODO: Implement getMemberById() method.
    }
}
