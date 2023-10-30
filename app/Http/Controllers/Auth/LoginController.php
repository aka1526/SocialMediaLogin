<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller{
    //All providers login
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    //All providers callback
    public function handleProviderCallback($provider)
    {
      //  dd($provider);
        $data= Socialite::driver($provider)->user();
        // print_r($user);
        $this->_registerOrLoginUser($data, $provider);
        // Return home after login
        return redirect()->intended();
    }
//Register or Login
    protected function _registerOrLoginUser($data, $provider)
    {
        //GET USER
        $user = User::where('email', $data->email)->first();

        //Create if not exists
        if (!$user) {
            //CREATE NEW USER
            $user = new User();
            $user->name = $data->name;
            $user->provider_id = $data->id;
            $user->provider = $data->provider;
            $user->email = empty($data->email)?"":$data->email;
            $user->img_avatar = empty($data->avatar)?"":$data->avatar;
            $user->save();
        }
        //LOGIN by object user
        Auth::login($user);
    }
}
