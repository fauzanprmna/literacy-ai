<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DefaultAnswer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id_answer_template',
        'name',
        'bobot',
    ];

    /**
     * DefaultAnswer belongs to an AnswerTemplate.
     */
    public function answerTemplate()
    {
        return $this->belongsTo(AnswerTemplate::class, 'id_answer_template', 'id');
    }

    /**
     * DefaultAnswer has many translations.
     */
    public function translations()
    {
        return $this->hasMany(DefaultAnswerTranslation::class, 'default_answer_id', 'id');
    }

    /**
     * DefaultAnswer translation for the current locale.
     */
    public function translation(): HasOne
    {
        return $this->hasOne(DefaultAnswerTranslation::class, 'default_answer_id', 'id')
            ->where('locale', app()->getLocale());
    }
}
