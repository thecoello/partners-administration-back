<?php

namespace App\Providers;

use App\Models\Users;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('email')) {

                $user = Users::where('email', $request->input('email'))->first();
                if(Hash::check($request->input('password'),$user->password)){

                    $tokenEnv = Hash::make(env('API_KEY'));
 
                    if(Hash::check($request->input('token'),$tokenEnv)){
                        return new GenericUser(['id' => $user->id, 'name' => $user->name, 'user_type' => $user->user_type, ]);
                    }else{
                        return false;
                    }
                }                 
            }
        });
    }
}
