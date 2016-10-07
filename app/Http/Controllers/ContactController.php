<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Notifications\SiteMessage;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class ContactController extends Controller
{
    public function sendSiteMessage(ContactFormRequest $request)
    {
        User::all()->each(function($user) use ($request) {
            $user->notify(new SiteMessage($request->acceptedFields()));
        });
    }
}
