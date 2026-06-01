<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModulRequest;
use App\Models\Modul;
use App\Models\ModulContent;
use App\Models\ModulTranslation;
use App\Models\Category;
use App\Services\TranslationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ModulController extends Controller
{
    public function __construct(protected TranslationService $translator) {}

    public function index(): View
    {
        // For mahasiswa view, fetch categories with count of modules
        if (Auth::user()->role === 'mahasiswa') {
            $categories = Category::with('translation')
                ->withCount('moduls')
                ->get();

            return view('modul.index', compact('categories'));
        }

        // For admin view, fetch Modul CRUD data
        $moduls = Modul::query()
            ->with(['translation', 'category.translation'])
            ->latest()
            ->paginate(10);

        return view('modul.index', compact('moduls'));
    }

    public function showByCategory(Category $category): View
    {
        $category->load('translation');
        $moduls = Modul::where('id_kategori', $category->id)
            ->with(['translation', 'category.translation'])
            ->get();

        return view('modul.by-category', compact('category', 'moduls'));
    }

    public function create(): View
    {
        return view('modul.create');
    }

    public function store(ModulRequest $request): RedirectResponse
    {
        // var_dump($request); // Debugging line, can be removed later
        // exit;
        // Prepare data for translation
        $rawData = [
            'id' => [
                'name' => $request->name_id,
                'description' => $request->isi_id ?? null,
            ],
            'en' => [
                'name' => $request->name_en,
                'description' => $request->isi_en ?? null,
            ],
        ];

        // Get translated data
        $translatedData = $this->translator->categoryTranslations($rawData);


        // Create modul with Indonesian data
        $modul = Modul::create([
            'name' => $translatedData['id']['name'],
            'id_kategori' => $request->id_kategori,
            'isi' => $translatedData['id']['description'],
            'link' => $request->link ?? null,
        ]);

        // Save translations for both locales
        foreach ($translatedData as $locale => $fields) {
            $modul->translations()->create([
                'locale' => $locale,
                'name' => $fields['name'],
                'isi' => $fields['description'],
            ]);
        }

        // Save new contents
        $this->saveModulContents($modul, $request);

        return redirect()
            ->route('modul.index')
            ->with('success', 'Modul berhasil dibuat.');
    }

    public function showContent($id): View
    {
        $content = ModulContent::where('modul_id', $id)
            ->with(['modul.translation', 'modul.category.translation'])
            ->orderBy('order')
            ->firstOrFail();
        $content->load([
            'modul.translation',
            'modul.category.translation'
        ]);

        // Previous content
        $prevContent = ModulContent::where('modul_id', $content->modul_id)
            ->where('order', '<', $content->order)
            ->orderByDesc('order')
            ->first();

        // Next content
        $nextContent = ModulContent::where('modul_id', $content->modul_id)
            ->where('order', '>', $content->order)
            ->orderBy('order')
            ->first();

        return view('modul.show', compact(
            'content',
            'prevContent',
            'nextContent'
        ));
    }

    public function edit(Modul $modul): View
    {
        $modul->load(['translation', 'contents']);
        return view('modul.edit', compact('modul'));
    }

    public function update(ModulRequest $request, Modul $modul): RedirectResponse
    {
        // Prepare data for translation
        $rawData = [
            'id' => [
                'name' => $request->name_id,
                'description' => $request->isi_id ?? null,
            ],
            'en' => [
                'name' => $request->name_en,
                'description' => $request->isi_en ?? null,
            ],
        ];

        // Get translated data
        $translatedData = $this->translator->categoryTranslations($rawData);

        // Update modul with Indonesian data
        $modul->update([
            'name' => $translatedData['id']['name'],
            'id_kategori' => $request->id_kategori,
            'isi' => $translatedData['id']['description'],
            'link' => $request->link ?? null,
        ]);

        // Update translations for both locales
        ModulTranslation::updateOrCreate(
            ['modul_id' => $modul->id, 'locale' => 'id'],
            ['name' => $translatedData['id']['name'], 'isi' => $translatedData['id']['description']]
        );
        ModulTranslation::updateOrCreate(
            ['modul_id' => $modul->id, 'locale' => 'en'],
            ['name' => $translatedData['en']['name'], 'isi' => $translatedData['en']['description']]
        );

        // Delete requested contents
        if ($request->has('delete_contents')) {
            ModulContent::whereIn('id', $request->delete_contents)
                ->where('modul_id', $modul->id)
                ->each(function ($content) {
                    if ($content->type === 'file' && $content->file_path) {
                        Storage::disk('public')->delete($content->file_path);
                    }
                    $content->delete();
                });
        }

        // Save new contents
        $this->saveModulContents($modul, $request);

        return redirect()
            ->route('modul.index')
            ->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroy(Modul $modul): RedirectResponse
    {
        // Delete all files associated with this modul
        $modul->contents()
            ->where('type', 'file')
            ->each(function ($content) {
                if ($content->file_path) {
                    Storage::disk('public')->delete($content->file_path);
                }
            });

        $modul->delete();

        return redirect()
            ->route('modul.index')
            ->with('success', 'Modul berhasil dihapus.');
    }

    /**
     * Save module contents (text, file, link).
     */
    private function saveModulContents(Modul $modul, ModulRequest $request): void
    {
        $order = $modul->contents()->max('order') ?? 0;

        // Save text contents
        if ($request->has('new_content_text')) {
            foreach ($request->new_content_text as $text) {
                if (!empty($text)) {
                    // Sanitize HTML from rich text editor
                    $sanitized = $this->sanitizeHtml($text);
                    $translatedData = $this->translator->modulContentTranslations([
                        'id' => ['content_id' => Auth::user()->language === 'id' ? $sanitized : null],
                        'en' => ['content_en' => Auth::user()->language === 'en' ? $sanitized : null], // Will be auto-translated
                    ]);
                    $modul->contents()->create([
                        'type' => 'text',
                        'content_id' => $translatedData['id']['content_id'],
                        'content_en' => $translatedData['en']['content_en'],
                        'order' => ++$order,
                    ]);
                }
            }
        }

        // Save file contents
        if ($request->has('new_content_file')) {
            foreach ($request->file('new_content_file') as $file) {
                if ($file !== null) {
                    $filePath = $file->store('modul-contents', 'public');
                    $modul->contents()->create([
                        'type' => 'file',
                        'file_path' => $filePath,
                        'order' => ++$order,
                    ]);
                }
            }
        }

        // Save link contents
        if ($request->has('new_content_link')) {
            foreach ($request->new_content_link as $link) {
                if (!empty($link)) {
                    $modul->contents()->create([
                        'type' => 'link',
                        'url' => $link,
                        'order' => ++$order,
                    ]);
                }
            }
        }
    }

    /**
     * Sanitize HTML content from rich text editor.
     */
    private function sanitizeHtml(string $html): string
    {
        // Allow safe HTML tags used by Quill
        $allowed_tags = '<p><br><strong><b><em><i><u><s><a><ul><ol><li><blockquote><pre><code><img><h1><h2><h3><h4><h5><h6><div><span>';

        // Strip disallowed tags
        $sanitized = strip_tags($html, $allowed_tags);

        // Remove dangerous attributes (javascript, onclick, etc)
        $sanitized = preg_replace('/ on\w+\s*=\s*["\']?[^"\']*["\']?/i', '', $sanitized);

        return $sanitized;
    }
}
