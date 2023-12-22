<?php

namespace App\Http\Controllers;

use Exception;
// use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirect(){

        return Socialite::driver('facebook')->redirect();
    }

    public function callback(){

            try {
                $fbuser = Socialite::driver('facebook')->user();
            } catch (InvalidStateException $e) {
                $fbuser = Socialite::driver('facebook')->stateless()->user();
            }
            //$fbuser = Socialite::driver('facebook')->stateless()->user();

            $finduser=User::where('provider_id','=',$fbuser->id)->where('provider','=','facebook')->first();
            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('dashboard');
            }else{


                $user = User::create([
                    'name' => $fbuser->name,
                    'email' => $fbuser->email,
                    'provider_id' => $fbuser->id,
                    'provider' => 'facebook',
                    'password' => Hash::make($fbuser->id),
                ]);

                event(new Registered($user));

                Auth::login($user);
            return redirect()->intended('dashboard');

            }

    }


}
