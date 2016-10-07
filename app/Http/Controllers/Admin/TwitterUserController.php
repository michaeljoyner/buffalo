<?php

namespace App\Http\Controllers\Admin;

use App\Social\Twitter;
use App\Social\TwitterUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TwitterUserController extends Controller
{
    public function fetchUser(Twitter $twitter)
    {
        $user = $twitter->getCurrentUser();

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

    public function setSharingStatus(Request $request, TwitterUser $twitterUser)
    {
        $this->validate($request, ['share' => 'required|boolean']);

        $state = $twitterUser->sharePosts($request->share);

        return response()->json(['new_state' => $state]);
    }
}
