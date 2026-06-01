<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $currentLanguage = $user->language ?? config('app.locale', 'en');
        $availableLanguages = [
            'en' => 'English',
            'id' => 'Bahasa Indonesia',
        ];

        return view('settings.index', [
            'user' => $user,
            'currentLanguage' => $currentLanguage,
            'availableLanguages' => $availableLanguages,
        ]);
    }

    public function updateLanguage(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:en,id',
        ]);

        $user = auth()->user();
        $user->update(['language' => $validated['language']]);

        session(['locale' => $validated['language']]);
        app()->setLocale($validated['language']);

        return redirect()->route('settings.index')->with('success', __('settings.language_updated'));
    }
}
