<?php

namespace App\Http\Controllers\Admin;

use App\SiteContent\SiteLinkGenerator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteLinkController extends Controller
{
    public function index(SiteLinkGenerator $generator)
    {
        return $generator->generate();
    }
}
