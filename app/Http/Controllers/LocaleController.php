<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'id'])) {
            return redirect()->back();
        }

        // Store in session and database if user is authenticated
        session(['locale' => $locale]);

        if (auth()->check()) {
            // Optionally store user's language preference
            auth()->user()->update(['language' => $locale]);
        }

        // Redirect back to previous page
        return redirect()->back();
    }
}
