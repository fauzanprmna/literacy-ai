<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Modul extends Model
{
    protected $table = 'moduls';

    protected $fillable = [
        'name',
        'id_kategori',
        'id_kategori_modul',
        'isi',
        'link',
    ];

    /**
     * Modul belongs to a Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id');
    }

    /**
     * Modul has many questions.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'modul_id');
    }

    /**
     * Modul has many translations.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ModulTranslation::class, 'modul_id');
    }

    /**
     * Modul translation for the current locale.
     */
    public function translation(): HasOne
    {
        return $this->hasOne(ModulTranslation::class, 'modul_id')
            ->where('locale', app()->getLocale());
    }

    /**
     * Modul has many contents.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(ModulContent::class, 'modul_id')->orderBy('order');
    }
}
