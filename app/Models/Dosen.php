<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dosen extends Model
{
    protected $table = 'dosens';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nidn',
        'nuptk',
        'prodi',
        'email_institusi',
        'no_telp',
        'alamat',
        'gelar_akademik',
    ];

    /**
     * Dosen belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
