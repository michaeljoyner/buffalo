<?php

namespace App\Http\Controllers\Admin;

use App\GooglePlusUser;
use App\Social\GooglePlus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GooglePlusUserController extends Controller
{
    public function fetchUser(GooglePlus $googlePlus)
    {
        $user = $googlePlus->getCurrentUser();
        return response()->json([
            'authorised' => $user->authorised,
            'user'       => [
                'name'      => $user->name,
                'cover_src' => $user->cover_src,
                'id'        => $user->id,
                'share'     => $user->share
            ]
        ]);
    }

    public function setSharingStatus(Request $request, GooglePlusUser $googlePlusUser)
    {
        $this->validate($request, ['share' => 'required|boolean']);

        $state = $googlePlusUser->sharePosts($request->share);

        return response()->json(['new_state' => $state]);
    }
}
