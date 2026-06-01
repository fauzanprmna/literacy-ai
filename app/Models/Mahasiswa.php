<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'prodi',
        'semester',
        'tahun_angkatan',
        'no_telp',
        'alamat',
        'nama_wali',
        'no_telp_wali',
    ];

    /**
     * Mahasiswa belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
