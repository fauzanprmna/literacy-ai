<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulTranslation extends Model
{
    protected $table = 'modul_translations';

    protected $fillable = [
        'modul_id',
        'locale',
        'name',
        'isi',
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }
}
