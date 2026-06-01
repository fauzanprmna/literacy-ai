# Panduan Sistem Translate (i18n)

## Implementasi Translate Indonesian <-> English

Sistem translate telah diimplementasikan menggunakan Laravel's built-in localization system. Berikut adalah panduan lengkapnya.

## Struktur Folder

```
resources/
  lang/
    en/
      common.php          # General UI strings (Back, Save, Update, etc)
      assessment.php      # Assessment-related strings
      ... (file lainnya)
    id/
      common.php
      assessment.php
      ... (file lainnya)
```

## Cara Menggunakan Translation

### 1. **Dalam View Files (Blade Templates)**

```blade
<!-- Menggunakan translation helper -->
{{ __('common.back') }}
{{ __('assessment.welcome') }}

<!-- Dengan parameter -->
{{ __('messages.welcome', ['name' => 'John']) }}

<!-- Dengan array keys -->
@foreach(__('assessment.instructions_text') as $instruction)
    <li>{{ $instruction }}</li>
@endforeach
```

### 2. **Dalam PHP/Controllers**

```php
// Dalam controller atau service
__('common.success')
trans('assessment.title')
trans('common.error')
```

### 3. **Dalam JavaScript**

```javascript
// Tapi lebih baik langsung dari Blade:
<span data-message="{{ __('common.loading') }}"></span>
```

## Menambah Translation Baru

### Step 1: Tambah Key ke File Translation

**resources/lang/en/assessment.php:**

```php
return [
    'new_feature' => 'New Feature Title',
    // ... existing keys
];
```

**resources/lang/id/assessment.php:**

```php
return [
    'new_feature' => 'Judul Fitur Baru',
    // ... existing keys
];
```

### Step 2: Gunakan di View

```blade
<h1>{{ __('assessment.new_feature') }}</h1>
```

## Language Switcher

Komponen language switcher sudah tersedia di:

```
resources/views/components/language-switcher.blade.php
```

### Menggunakan Language Switcher

Tambahkan di template:

```blade
@include('components.language-switcher')
```

Atau di Tailwind:

```blade
<x-language-switcher />
```

## Routes Locale

```php
// Change language to English
GET /locale/en

// Change language to Indonesian
GET /locale/id

// User akan diredirect kembali ke halaman sebelumnya
```

## Workflow Translate

1. **User click language button** → Kirim ke `/locale/{locale}`
2. **LocaleController.setLocale()** → Set locale di session
3. **SetLocale middleware** → Set app locale untuk setiap request
4. **\_\_() helper** → Read dari translation files sesuai locale

## Tips

### Menggunakan Cara Shortcut

```blade
<!-- Panjang -->
{{ __('common.back') }}

<!-- Shortcut dengan @ -->
@lang('common.back')

<!-- Plural (jika perlu) -->
{{ trans_choice('messages.apples', 5) }}
```

### Best Practices

1. **Organize keys logically** - Group related translations
2. **Use dot notation** - `assessment.welcome` instead of `assessment_welcome`
3. **Avoid hardcoding text** - Always use translation keys
4. **Keep keys consistent** - Use same keys across all languages
5. **Add comments** - Document complex translations

## Current Translation Files

### common.php

- Basic UI actions (back, save, update, delete, etc)
- Status messages (success, error, warning)
- Language selection

### assessment.php

- Assessment page titles and headers
- Instructions and descriptions
- Results pages text
- Module recommendations

## Next Steps

Untuk melengkapi translation, Anda perlu:

1. **Update existing views** - Ganti hardcoded text dengan `__()` helper
2. **Create more translation files** - Untuk modules, questions, users
3. **Add database migration** - Untuk menyimpan user language preference
4. **Test both languages** - Pastikan semua text translated

## Database Migration (Optional)

Jika ingin menyimpan preferensi bahasa user di database:

```bash
php artisan make:migration add_language_to_users_table
```

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('language')->default('en')->after('password');
});
```

Kemudian di LocaleController:

```php
if (auth()->check()) {
    auth()->user()->update(['language' => $locale]);
}

// Dan di middleware SetLocale:
$locale = auth()->check() ? auth()->user()->language : session('locale');
```

---

**Catatan:** Sistem ini menggunakan Laravel 12's built-in localization. Semua translation files disimpan di `resources/lang/`.
