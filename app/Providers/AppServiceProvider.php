<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ShortUrl;
use App\Models\User;
use App\Policies\ShortUrlPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
class AppServiceProvider extends ServiceProvider
{


    protected $policies = [
        ShortUrl::class => ShortUrlPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('invite_user', function ($user , $company_id , $role_id) {
            if($role_id == 1){
                return Response::deny('Super admin can not be invited.');
            }
            if($user->role_id == 1 && $role_id == 3){
                return Response::deny('Member cannot be invite.');
            }
            if($user->role_id == 3){
                return Response::deny('Member cannot invite.');
            }
            if ($user->role_id == 2 && $company_id != $user->company_id) {
                return Response::deny('Cannot invite outside of company.');
            }
            return Response::allow();
        });
    }
}
