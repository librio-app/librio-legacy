<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Activate;
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

    public function activate(Activate $request, string $confirmationKey)
    {
        $password = $request->validated('password');

        $member = $this->memberService->getMemberByConformationCode($confirmationKey);
        if (!$member instanceof Member) {
            return redirect()->back();
        }

        $member->password = \Hash::make($password);
        $member->save();
        \Auth::login($member);

        return redirect()->route('opac');
    }
}
