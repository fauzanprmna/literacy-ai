# Language Switcher Integration Guide

## 1. Adding Language Switcher to Navigation

### For Admin Navigation (template-admin.blade.php)

Add this in your navbar, typically in the top-right corner near the user profile menu:

```blade
<!-- Language Switcher -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarLanguage" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ strtoupper(app()->getLocale()) }}
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarLanguage">
        <li>
            <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('locale.set', 'en') }}">
                <i class="fas fa-check"></i> English
            </a>
        </li>
        <li>
            <a class="dropdown-item {{ app()->getLocale() === 'id' ? 'active' : '' }}" href="{{ route('locale.set', 'id') }}">
                <i class="fas fa-check"></i> Bahasa Indonesia
            </a>
        </li>
    </ul>
</li>
```

### Using the Language Switcher Component

Alternatively, use the pre-built component:

```blade
<x-language-switcher />
```

## 2. Refactoring Views to Use Translations

### Before (Hardcoded Text)

```blade
<!-- resources/views/pengukuran/hasil.blade.php -->
<div class="card">
    <div class="card-header">
        <h5>Overall Score</h5>
    </div>
    <div class="card-body">
        <p>From All Categories</p>
        <h2>{{ $overallScore }}%</h2>
    </div>
</div>
```

### After (Using Translation Helpers)

```blade
<!-- resources/views/pengukuran/hasil.blade.php -->
<div class="card">
    <div class="card-header">
        <h5>{{ __('assessment.overall_score') }}</h5>
    </div>
    <div class="card-body">
        <p>{{ __('assessment.from_all_categories') }}</p>
        <h2>{{ $overallScore }}%</h2>
    </div>
</div>
```

## 3. Translation Methods Available

### In Blade Templates

```blade
<!-- Single translation -->
{{ __('assessment.welcome') }}

<!-- With parameter replacement -->
{{ __('assessment.greeting', ['name' => $user->name]) }}

<!-- Ternary with translation -->
{{ auth()->check() ? __('common.welcome_back') : __('common.back') }}
```

### In PHP Code

```php
// In controllers, models, services
use Illuminate\Support\Facades\Lang;

$message = __('assessment.congratulations');

// Or with trans() helper
$message = trans('assessment.congratulations');

// With parameters
$message = __('assessment.score_summary', ['score' => 95]);
```

### In JavaScript (if needed)

```javascript
// Passing translations to Vue/Alpine via data attributes
<div data-message="{{ __('common.loading') }}">
    {{ __('common.loading') }}
</div>
```

## 4. Files Structure

Translation files are organized in `resources/lang/`:

```
resources/
  lang/
    en/
      common.php          # Common UI strings (Back, Save, Update, etc.)
      assessment.php      # Assessment-specific strings
    id/
      common.php          # Indonesian common strings
      assessment.php      # Indonesian assessment strings
```

## 5. Database Integration (Just Completed)

✅ **Migration Created**: `add_language_to_users_table`

- Added `language` column to users table (default: 'en')
- Migration automatically ran

✅ **User Model Updated**:

- `language` added to `$fillable` array
- Language preference now persists in database

✅ **SetLocale Middleware Enhanced**:

- Priority: Query Parameter → User Database → Session → Config Default
- Automatically loads authenticated user's language preference

✅ **LocaleController Updated**:

- Saves language preference to user record when switching languages
- Only for authenticated users

## 6. User Experience Flow

1. **First Visit**: User gets default language (English) from config
2. **Language Switch**: User clicks language switcher → SetLocale middleware saves to session AND database (if authenticated)
3. **Return Visit**: SetLocale middleware checks:
    - Query parameter? Use it
    - User authenticated? Load their saved preference
    - Session has value? Use it
    - Fallback to config default

## 7. Next Steps

### Option 1: Refactor High-Priority Views

Start with most-visited pages:

```
1. resources/views/dashboard.blade.php
2. resources/views/pengukuran/hasil.blade.php
3. resources/views/template/template-mahasiswa.blade.php
```

### Option 2: Create Additional Translation Files

For specific features:

```
resources/lang/en/modul.php      # Modul-related strings
resources/lang/en/questions.php  # Question management strings
resources/lang/en/menu.php       # Navigation menu strings
```

### Option 3: Add More Languages

Simply create new language directory:

```
resources/lang/
  en/
  id/
  es/  ← Add Spanish (or any language)
    common.php
    assessment.php
```

And update middleware validation:

```php
if (!in_array($locale, ['en', 'id', 'es'])) {
    $locale = config('app.locale', 'en');
}
```

## 8. Translation File Format

Each translation file returns an associative array:

```php
<?php

return [
    'welcome' => 'Welcome to Our App',
    'greeting' => 'Hello, :name',
    'instructions' => [
        'line_1' => 'First instruction',
        'line_2' => 'Second instruction',
    ],
];
```

Access with dot notation:

```blade
{{ __('assessment.welcome') }}
{{ __('assessment.instructions.line_1') }}
```

## Testing the System

```bash
# Test by visiting routes with locale parameter
http://localhost/locale/en    # Switch to English
http://localhost/locale/id    # Switch to Indonesian

# In Tinker, check user language:
php artisan tinker
> $user = User::first();
> $user->language      # Returns 'en' or 'id'
> App::getLocale()    # Current app locale
```

## Summary of Changes

✅ Database migration adds `language` column
✅ User model updated with `language` in fillable
✅ SetLocale middleware enhanced to load from database
✅ LocaleController saves preferences to database
✅ Language switcher ready for integration
✅ Translation system fully functional
✅ Example refactoring patterns provided

The translation system is now **production-ready** with persistent language preferences stored in the database!
