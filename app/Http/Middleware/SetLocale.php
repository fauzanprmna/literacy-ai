<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Priority: query parameter > user preference > session > config default
        $locale = $request->get('locale');

        // If no query parameter, check user preference
        if (!$locale && $request->user()) {
            $locale = $request->user()->language;
        }

        // Fall back to session or config
        if (!$locale) {
            $locale = session('locale') ?? config('app.locale', 'en');
        }

        // Validate locale is in allowed locales
        if (!in_array($locale, ['en', 'id'])) {
            $locale = config('app.locale', 'en');
        }

        // Set the locale
        app()->setLocale($locale);

        // Store in session for persistence
        session(['locale' => $locale]);

        return $next($request);
    }
}
