<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
use Exception;
use Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function pagelogin(){

        return Socialite::driver('google')->redirect();
    }

    public function pageredirect(){

            try {
                $fbuser = Socialite::driver('google')->user();
            } catch (InvalidStateException $e) {
                $fbuser = Socialite::driver('google')->stateless()->user();
            }

            $finduser=User::where('provider_id','=',$fbuser->id)->where('provider','=','google')->first();
            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            }else{


                $user = User::create([
                    'name' => $fbuser->name,
                    'email' => $fbuser->email,
                    'provider_id' => $fbuser->id,
                    'provider' => 'google',
                    'password' => Hash::make($fbuser->id),
                ]);

                event(new Registered($user));

                Auth::login($user);
            return redirect()->intended('dashboard');

            }

    }


}
