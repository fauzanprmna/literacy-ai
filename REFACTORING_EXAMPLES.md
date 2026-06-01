# Refactoring Examples: Hardcoded Text → Translation Helpers

This file shows before/after examples for refactoring views to use Laravel translation helpers.

## Example 1: Dashboard Welcome Section

### Before

```blade
<section class="p-6">
    <div class="card">
        <div class="card-header">
            <h1>Welcome back, {{ Auth::user()->name }}!</h1>
        </div>
        <div class="card-body">
            <p>Complete your literacy assessment to track your progress.</p>
            <a href="/pengukuran" class="btn btn-primary">Start Assessment</a>
        </div>
    </div>
</section>
```

### After

```blade
<section class="p-6">
    <div class="card">
        <div class="card-header">
            <h1>{{ __('assessment.welcome') }}, {{ Auth::user()->name }}!</h1>
        </div>
        <div class="card-body">
            <p>{{ __('assessment.instructions.0') }}</p>
            <a href="/pengukuran" class="btn btn-primary">{{ __('assessment.start_assessment') }}</a>
        </div>
    </div>
</section>
```

### Translation Files Needed

```php
// resources/lang/en/assessment.php
'welcome' => 'Welcome back',
'instructions' => [
    'Complete your literacy assessment to track your progress.',
    'Answer all questions honestly...',
],
'start_assessment' => 'Start Assessment',

// resources/lang/id/assessment.php
'welcome' => 'Selamat datang kembali',
'instructions' => [
    'Selesaikan penilaian literasi Anda untuk melacak kemajuan Anda.',
    'Jawab semua pertanyaan dengan jujur...',
],
'start_assessment' => 'Mulai Penilaian',
```

---

## Example 2: Results Page Score Cards

### Before

```blade
<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Overall Score</h5>
        </div>
        <div class="card-body text-center">
            <p class="text-muted">From All Categories</p>
            <h2 class="text-primary">{{ $overallScore }}%</h2>
            <span class="badge bg-success">{{ $instrumentScore }}</span>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5>Recommended Categories</h5>
        </div>
        <div class="card-body">
            @if(count($recommendedCategories) > 0)
                <p>The following categories need improvement:</p>
                <ul>
                    @foreach($recommendedCategories as $category)
                        <li>{{ $category }}</li>
                    @endforeach
                </ul>
            @else
                <p>No categories to improve!</p>
            @endif
        </div>
    </div>
</div>
```

### After

```blade
<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>{{ __('assessment.overall_score') }}</h5>
        </div>
        <div class="card-body text-center">
            <p class="text-muted">{{ __('assessment.from_all_categories') }}</p>
            <h2 class="text-primary">{{ $overallScore }}%</h2>
            <span class="badge bg-success">{{ __('assessment.rating', ['rating' => $instrumentScore]) }}</span>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5>{{ __('assessment.module_recommendations') }}</h5>
        </div>
        <div class="card-body">
            @if(count($recommendedCategories) > 0)
                <p>{{ __('assessment.categories_need_improvement') }}</p>
                <ul>
                    @foreach($recommendedCategories as $category)
                        <li>{{ $category }}</li>
                    @endforeach
                </ul>
            @else
                <p>{{ __('assessment.congratulations') }}</p>
            @endif
        </div>
    </div>
</div>
```

### Translation Files Needed

```php
// resources/lang/en/assessment.php
'overall_score' => 'Overall Score',
'from_all_categories' => 'From All Categories',
'rating' => ':rating',
'module_recommendations' => 'Recommended Categories',
'categories_need_improvement' => 'The following categories need improvement:',
'congratulations' => 'Congratulations! No categories to improve!',

// resources/lang/id/assessment.php
'overall_score' => 'Skor Keseluruhan',
'from_all_categories' => 'Dari Semua Kategori',
'rating' => ':rating',
'module_recommendations' => 'Kategori yang Direkomendasikan',
'categories_need_improvement' => 'Kategori berikut memerlukan peningkatan:',
'congratulations' => 'Selamat! Tidak ada kategori yang perlu ditingkatkan!',
```

---

## Example 3: Question Form Labels

### Before

```blade
<form action="{{ route('answer.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Question {{ $currentQuestion }}</label>
        <p class="text-muted">Category: {{ $question->category->name }}</p>
        <div class="mb-3">
            <label class="form-label">Your Answer</label>
            <textarea class="form-control" name="answer" placeholder="Enter your answer..."></textarea>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-secondary" type="submit" name="action" value="back">Back</button>
        <button class="btn btn-primary" type="submit" name="action" value="next">Next</button>
        <button class="btn btn-success" type="submit" name="action" value="submit">Submit</button>
    </div>
</form>
```

### After

```blade
<form action="{{ route('answer.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">{{ __('assessment.question') }} {{ $currentQuestion }}</label>
        <p class="text-muted">{{ __('assessment.category') }}: {{ $question->category->name }}</p>
        <div class="mb-3">
            <label class="form-label">{{ __('assessment.your_answer') }}</label>
            <textarea class="form-control" name="answer" placeholder="{{ __('assessment.enter_answer_placeholder') }}"></textarea>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-secondary" type="submit" name="action" value="back">{{ __('common.back') }}</button>
        <button class="btn btn-primary" type="submit" name="action" value="next">{{ __('common.next') }}</button>
        <button class="btn btn-success" type="submit" name="action" value="submit">{{ __('common.submit') }}</button>
    </div>
</form>
```

### Translation Files Needed

```php
// resources/lang/en/assessment.php
'question' => 'Question',
'category' => 'Category',
'your_answer' => 'Your Answer',
'enter_answer_placeholder' => 'Enter your answer...',

// resources/lang/en/common.php
'back' => 'Back',
'next' => 'Next',
'submit' => 'Submit',

// resources/lang/id/assessment.php
'question' => 'Pertanyaan',
'category' => 'Kategori',
'your_answer' => 'Jawaban Anda',
'enter_answer_placeholder' => 'Masukkan jawaban Anda...',

// resources/lang/id/common.php
'back' => 'Kembali',
'next' => 'Berikutnya',
'submit' => 'Kirim',
```

---

## Example 4: Navigation Menu

### Before

```blade
<nav class="navbar">
    <div class="navbar-nav">
        <a class="nav-link" href="/dashboard">Dashboard</a>
        <a class="nav-link" href="/pengukuran">Assessment</a>
        <a class="nav-link" href="/modul">Learning Modules</a>
        <a class="nav-link" href="/results">My Results</a>
    </div>
    <div class="navbar-user">
        <span>User: {{ Auth::user()->name }}</span>
        <a href="{{ route('logout') }}">Logout</a>
    </div>
</nav>
```

### After

```blade
<nav class="navbar">
    <div class="navbar-nav">
        <a class="nav-link" href="/dashboard">{{ __('menu.dashboard') }}</a>
        <a class="nav-link" href="/pengukuran">{{ __('menu.assessment') }}</a>
        <a class="nav-link" href="/modul">{{ __('menu.learning_modules') }}</a>
        <a class="nav-link" href="/results">{{ __('menu.my_results') }}</a>
    </div>
    <div class="navbar-user">
        <span>{{ __('common.user') }}: {{ Auth::user()->name }}</span>
        <a href="{{ route('logout') }}">{{ __('common.logout') }}</a>
    </div>
</nav>
```

### Translation Files Needed

```php
// resources/lang/en/menu.php (NEW FILE)
return [
    'dashboard' => 'Dashboard',
    'assessment' => 'Assessment',
    'learning_modules' => 'Learning Modules',
    'my_results' => 'My Results',
];

// resources/lang/id/menu.php (NEW FILE)
return [
    'dashboard' => 'Panel Kontrol',
    'assessment' => 'Penilaian',
    'learning_modules' => 'Modul Pembelajaran',
    'my_results' => 'Hasil Saya',
];

// resources/lang/en/common.php (ADD TO EXISTING)
'user' => 'User',
'logout' => 'Logout',

// resources/lang/id/common.php (ADD TO EXISTING)
'user' => 'Pengguna',
'logout' => 'Keluar',
```

---

## Quick Reference: Translation Helper Syntax

```blade
{{-- Simple translation --}}
{{ __('key.name') }}

{{-- With parameters --}}
{{ __('key.message', ['param' => 'value']) }}

{{-- Pluralization --}}
{{ trans_choice('items.count', $count) }}

{{-- In PHP code --}}
use Illuminate\Support\Facades\Lang;
$text = __('key.name');
$text = Lang::get('key.name');
$text = trans('key.name');

{{-- Conditional translation --}}
{{ auth()->check() ? __('common.welcome_back') : __('common.welcome') }}

{{-- In form validation messages --}}
'email.required' => __('validation.email_required'),
```

---

## Tips for Refactoring

1. **Start Small**: Begin with one view, test thoroughly before moving to next
2. **Group Related Strings**: Keep translations organized by feature (assessment, menu, validation)
3. **Use Descriptive Keys**: Use `welcome_message` not `msg_1`
4. **Test Both Languages**: Always verify by switching locales
5. **Document Parameters**: When using `:param`, document what it contains
6. **Gradual Migration**: Existing hardcoded text still works—no rush to refactor everything
7. **Version Control**: Commit translation files and refactored views separately

---

## Validation

After refactoring, test with:

```bash
# Switch language and verify text changes
http://localhost/locale/en
http://localhost/locale/id

# In Tinker
php artisan tinker
> __('assessment.welcome')
> __('common.back')
> app()->getLocale()
```
