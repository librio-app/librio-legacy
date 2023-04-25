<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\MemberArea\Services\MemberServiceInterface;
use App\Models\Administration\Member;

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
        $member = $this->memberService->getMemberByConformationCode($confirmationKey);

        if (!$member instanceof Member) {
            $message = trans('auth.activate_expired');
            flash($message)->error();
        }

        return view('member.activate.show', [
            'confirmationKey' => $confirmationKey,
            'member' => $member
        ]);
    }

    public function activate(string $confirmationKey)
    {
        $member = $this->memberService->getMemberByConformationCode($confirmationKey);
        // TODO get params, save password
        // TODO login \Auth::login($member);

        return redirect()->route('opac');
    }
}
