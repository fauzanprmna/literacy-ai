<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\TranslationService;

class CategoryController extends Controller
{
    public function __construct(protected TranslationService $translator) {}

    public function index(): View
    {
        $categories = Category::query()->latest()->paginate(10);

        return view('category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('category.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        // Prepare data for translation
        $rawData = [
            'id' => [
                'name' => $request->name_id,
                'description' => $request->deskripsi_id ?? null,
            ],
            'en' => [
                'name' => $request->name_en,
                'description' => $request->deskripsi_en ?? null,
            ],
        ];

        // Get translated data (auto-fill missing translations)
        $translatedData = $this->translator->categoryTranslations($rawData);

        // Create single category with Indonesian name
        $category = Category::create([
            'name' => $translatedData['id']['name'],
            'bobot' => $request->bobot ?? 1,
        ]);

        foreach ($translatedData as $locale => $fields) {
            $category->translations()->create([
                'category_id' => $category->id,
                'locale'      => $locale,
                'name'        => $fields['name'],
                'description' => $fields['description'],
            ]);
        }

        // Save translations for both locales
        // CategoryTranslation::updateOrCreate(
        //     ['category_id' => $category->id, 'locale' => 'id'],
        //     ['name' => $translatedData['id']['name'], 'description' => $translatedData['id']['description']]
        // );
        // CategoryTranslation::updateOrCreate(
        //     ['category_id' => $category->id, 'locale' => 'en'],
        //     ['name' => $translatedData['en']['name'], 'description' => $translatedData['en']['description']]
        // );

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function show(Category $category): View
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        // Prepare data for translation
        $rawData = [
            'id' => [
                'name' => $request->name_id,
                'description' => $request->deskripsi_id ?? null,
            ],
            'en' => [
                'name' => $request->name_en,
                'description' => $request->deskripsi_en ?? null,
            ],
        ];

        // Get translated data
        $translatedData = $this->translator->categoryTranslations($rawData);

        // Update category with Indonesian data
        $category->update([
            'name' => $translatedData['id']['name'],
            'description' => $translatedData['id']['description'],
            'bobot' => $request->bobot ?? $category->bobot,
        ]);

        // Update translations for both locales
        CategoryTranslation::updateOrCreate(
            ['category_id' => $category->id, 'locale' => 'id'],
            ['name' => $translatedData['id']['name'], 'description' => $translatedData['id']['description']]
        );
        CategoryTranslation::updateOrCreate(
            ['category_id' => $category->id, 'locale' => 'en'],
            ['name' => $translatedData['en']['name'], 'description' => $translatedData['en']['description']]
        );

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
