<?php

namespace App\Http\Controllers;

// app/Http/Controllers/PageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Index (Homepage)
    public function index()
    {
        return view('pages.index');
    }

    // Privacy Policy
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    // Terms and Conditions
    public function termsAndConditions()
    {
        return view('pages.terms-and-conditions');
    }
}
