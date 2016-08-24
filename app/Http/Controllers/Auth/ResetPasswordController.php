<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\FlashMessaging\Flasher;
use App\Http\Requests\ResetPasswordRequest;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    /**
     * @var Flasher
     */
    private $flasher;

    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @param Flasher $flasher
     */
    public function __construct(Flasher $flasher)
    {
        $this->middleware('guest', ['except' => ['showLoggedInUserPasswordReset', 'loggedInUserReset']]);
        $this->flasher = $flasher;
    }

    public function showLoggedInUserPasswordReset()
    {
        return view('admin.users.resetpassword');
    }

    public function loggedInUserReset(ResetPasswordRequest $request)
    {
        User::findOrFail($request->user()->id)->resetPassword($request->password);

        $this->flasher->success('Success', 'Your password has been reset');

        return redirect('admin/users');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();

        $this->guard()->login($user);
    }
}
