<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Auth\VerifyMail;
use App\Entity\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    //use RegistersUsers;

    //protected $redirectTo = '/home';
    protected $redirectTo = '/cabinet';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_code', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be verified');
        }

        if ($user->status !== User::STATUS_WAIT) {
            return redirect()->route('login')
                ->with('error', 'Your e-mail is already verified.');
        }

        $user->status = User::STATUS_ACTIVE;
        $user->verify_code = null;
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Your e-mail is verified. You can login now.');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Entity\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verify_token' => Str::uuid(),
            'status' => User::STATUS_WAIT,
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));
        event(new Registered($user));

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the verification link');
    }
}
