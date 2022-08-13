<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    const ANSWER_TYPE_TEXT = 'text';
    const ANSWER_TYPE_FILE = 'file';

    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function getQuestionFilePathAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function getAnswerFilePathAttribute($value)
    {
        if ($this->answer_type == self::ANSWER_TYPE_FILE) {
            return asset('storage/' . $value);
        }

        return null;
    }
    
}
