<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Exception;

class SocialController extends Controller
{
    public function facebookRedirect()
    {
          return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {$user = Socialite::driver('facebook')->user();
            $isUser = User::where('fb_id', $user->id,)->first();

            if ($isUser) {
                Auth::login($isUser);

                return redirect('/user/dashboard');
            } else{
                $createUser = User::create([
                    'name'=> $user->name,
                    'email'=> $user->email,
                    'fb_id'=> $user->id,
                    'role_id'=> 2,
                    'password'=> encrypt('user'),
                ]);

                Auth::login($createUser);
                return redirect('/user/dashboard');
            }

        }catch (Exception $exception){
            dd($exception->getMessage());
        }

    }
}
