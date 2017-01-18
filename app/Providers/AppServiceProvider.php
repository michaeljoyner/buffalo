<?php

namespace App\Providers;

use App\Exceptions\LastUserDeletionException;
use App\Social\GooglePlusUser;
use App\User;
use Google_Service_Plus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::deleting(function($user) {
            if(User::count() < 2) {
                throw new LastUserDeletionException;
            }
        });

        Validator::extend('password', function($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::user()->password);
        });

        Validator::extend('currency', function($attribute, $value, $parameters, $validator) {
            return in_array(strtoupper($value), array_keys(config('currency_codes')));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Google_Client::class, function($app) {
            $client = new \Google_Client();
            $client->setAuthConfig(config('googleplus'));
            $client->addScope([
                Google_Service_Plus::PLUS_ME,
                'https://www.googleapis.com/auth/plus.stream.write'
            ]);
            $client->setAccessType('offline');
            $client->setApprovalPrompt('force');
            $client->setRedirectUri('http://buffalo.app:8000/admin/googleplus/callback');
            return $client;
        });
    }
}
