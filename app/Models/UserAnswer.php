<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'answer_bobot',
    ];

    /**
     * UserAnswer belongs to a Question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * UserAnswer belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
