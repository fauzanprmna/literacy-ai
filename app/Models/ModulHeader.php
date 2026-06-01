<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulHeader extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id_kategori',
        'name',
        'description',
    ];

    /**
     * ModulHeader belongs to a Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id');
    }

    /**
     * ModulHeader has many ModulDetails.
     */
    public function details()
    {
        return $this->hasMany(ModulDetail::class, 'id_modul_header', 'id');
    }
}
