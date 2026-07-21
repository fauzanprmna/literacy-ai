<?php

namespace App\Models\ML;

use Illuminate\Database\Eloquent\Model;

class ScrapedContent extends Model
{
    protected $table = 'contents';

    protected $fillable = [
        'title',
        'url',
        'description',
        'source',      // 'youtube' atau 'journal'
        'author',
        'date'
    ];

    // Relasi ke classification
    public function classification()
    {
        return $this->hasOne(
            ContentClassification::class,
            'content_id',
            'id'
        );
    }
    // Helper untuk mendapat dimension
    public function getDimension()
    {
        return $this->classification?->dimension ?? 'Unknown';
    }

    // Helper untuk mendapat confidence
    public function getConfidence()
    {
        return $this->classification?->confidence ?? 0;
    }
}
