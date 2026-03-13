<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShortUrl;
use Illuminate\Auth\Access\Response;
class ShortUrlPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(User $user , ShortUrl $shortUrl): bool
    {
        return $user->role_id==1 || $shortUrl->company_id !== $user->company_id;
    }
    public function create(User $user)
    {
        if($user->role_id==1){
            return Response::deny('You are not authorized to create link.');
        }
        return true;
    }

    public function resolve(User $user, ShortUrl $shortUrl)
    {
        if ($user->role_id==1) {
            return true;
        }

        if ($user->role_id==2 && $shortUrl->company_id !== $user->company_id) {
            return Response::deny('You are not authorized to view this link.');
        }

        if ($user->role_id==3 && $shortUrl->user_id !== $user->id) {
            return Response::deny('You are not authorized to view this link.');
        }

        return true;
    }
}
