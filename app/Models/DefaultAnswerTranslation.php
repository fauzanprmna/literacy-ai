<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultAnswerTranslation extends Model
{
    protected $table = 'default_answer_translations';

    protected $fillable = [
        'default_answer_id',
        'locale',
        'name',
    ];

    public function defaultAnswer()
    {
        return $this->belongsTo(DefaultAnswer::class);
    }
}
