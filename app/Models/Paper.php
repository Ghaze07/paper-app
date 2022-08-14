<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function setQuestionFileNameAttribute($value)
    {
        $this->attributes['question_file_name'] = str_replace(' ', '_', $value);
    }

    public function setQuestionFilePathAttribute($value)
    {
        $this->attributes['question_file_path'] = str_replace(' ', '_', $value);
    }

    public function setAnswerFileNameAttribute($value)
    {
        if ($this->answer_type == self::ANSWER_TYPE_FILE) {
            $this->attributes['answer_file_name'] = str_replace(' ', '_', $value);
        }
    }

    public function setAnswerFilePathAttribute($value)
    {
        if ($this->answer_type == self::ANSWER_TYPE_FILE) {
            $this->attributes['answer_file_path'] = str_replace(' ', '_', $value);
        }
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

    public function deleteExistingQuestionPaper()
    {
        $path = storage_path('app/public/papers/'.$this->attributes['question_file_name']) ;
        if (is_file($path)) {
            unlink($path);
        }

        return true;
    }

    public function deleteExistingAnswerPaper()
    {
        if ($this->answer_type == self::ANSWER_TYPE_FILE) {
            $path = storage_path('app/public/papers/'.$this->attributes['answer_file_name']);

            if (is_file($path)) {
                unlink($path);
            }
        }

        return true;
    }
    
}
