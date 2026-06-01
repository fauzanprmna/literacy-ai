<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModulContent extends Model
{
    protected $table = 'modul_contents';

    protected $fillable = [
        'modul_id',
        'type',
        'content_id',
        'content_en',
        'file_path',
        'url',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the modul that owns this content.
     */
    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }
}
