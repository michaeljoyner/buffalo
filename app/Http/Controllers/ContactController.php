<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\SiteMessage;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendSiteMessage(ContactFormRequest $request)
    {
        Mail::to('sales@buffalo-tools.com')->send(new SiteMessage($request->acceptedFields()));
    }
}
