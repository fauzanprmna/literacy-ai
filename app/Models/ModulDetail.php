<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id_modul_header',
        'kategori_modul',
        'name',
        'link',
    ];

    /**
     * ModulDetail belongs to a ModulHeader.
     */
    public function header()
    {
        return $this->belongsTo(ModulHeader::class, 'id_modul_header', 'id');
    }
}
