<?php

namespace App\Http\Controllers\Admin;

use App\Social\Facebook;
use App\Social\FacebookUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class FacebookUserController extends Controller
{
    public function fetchCurrent(Facebook $facebook)
    {
        $user = $facebook->getCurrentUserDetails();

        return response()
            ->json([
                'authorised' => $user->authorised,
                'user'       => [
                    'name'      => $user->name,
                    'cover_src' => $user->cover_src,
                    'id'        => $user->id,
                    'share'     => $user->share
                ]
            ]);
    }

    public function setSharingStatus(Request $request, FacebookUser $facebookUser)
    {
        $this->validate($request, ['share' => 'required|boolean']);

        $state = $facebookUser->sharePosts($request->share);

        return response()->json(['new_state' => $state]);
    }
}
