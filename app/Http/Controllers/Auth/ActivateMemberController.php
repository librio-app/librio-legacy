<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\MemberArea\Services\MemberServiceInterface;

class ActivateMemberController extends Controller
{
    private MemberServiceInterface $memberService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MemberServiceInterface $memberService)
    {
        $this->middleware('guest');
        $this->memberService = $memberService;
    }

    public function show(string $confirmationKey)
    {
        return view('member.activate.show', ['confirmationKey' => $confirmationKey]);
    }

    public function activate(string $confirmationKey)
    {
        $member = $this->memberService->getMemberByConformationCode($confirmationKey);
        // TODO get params, save password
        // TODO login \Auth::login($member);

        return redirect()->route('opac');
    }
}
