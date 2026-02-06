<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    function HomePage(){
        return Inertia::render('HomePage');
    }
    function ProfilePage(){
        return Inertia::render('ProfilePage');
    }
}
