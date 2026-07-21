<?php

namespace App\Models\ML;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class ContentClassification extends Model
{
    protected $table = 'classifications';

    protected $fillable = [
        'content_id',
        'dimension',  // 4 dimensi: Conceptual, Application, Critical, Ethical
        'confidence'
    ];

    public function content()
    {
        return $this->belongsTo(ScrapedContent::class, 'content_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'dimension', 'name');
    }
}
