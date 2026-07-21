<?php

namespace App\Models;

use App\Models\ML\ContentClassification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'bobot',
    ];

    /**
     * Category has many questions.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'id_kategori', 'id');
    }

    /**
     * Category has many moduls.
     */
    public function moduls(): HasMany
    {
        return $this->hasMany(Modul::class, 'id_kategori', 'id');
    }

    public function dimension(): HasMany
    {
        return $this->hasMany(ContentClassification::class, 'dimension', 'name');
    }

    /**
     * Category has many translations.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id');
    }

    /**
     * Category translation for the current locale.
     */
    public function translation(): HasOne
    {
        return $this->hasOne(CategoryTranslation::class, 'category_id', 'id')
            ->where('locale', app()->getLocale());
    }
}
