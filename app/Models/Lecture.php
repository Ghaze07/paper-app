<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecture extends Model
{
    use HasFactory;

    protected $guarded = [];

    const LECTURE_TYPE_LINK = 'link';
    const LECTURE_TYPE_FILE = 'file';
    const LECTURE_TYPE_NONE = 'none';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function setFileNameAttribute($value)
    {
        if ($this->type == self::LECTURE_TYPE_FILE) {
            $this->attributes['file_name'] = str_replace(' ', '_', $value);
        }
    }

    public function setFilePathAttribute($value)
    {
        if ($this->type == self::LECTURE_TYPE_FILE) {
            $this->attributes['file_path'] = str_replace(' ', '_', $value);
        }
    }

    public function deleteExistingFile()
    {
        // if ($this->type == self::LECTURE_TYPE_FILE) {
        //     Storage::disk('public')->delete($this->file_path);
        // }
    }

    public function getFilePathAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }
    }
}
