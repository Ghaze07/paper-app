<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    
    protected $guarded = [];


    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function setFileNameAttribute($value)
    {
        if ($value) {
            $this->attributes['file_name'] = str_replace(' ', '_', $value);
        }
    }

    public function setFilePathAttribute($value)
    {
        if ($value) {
            $this->attributes['file_path'] = str_replace(' ', '_', $value);
        }
    }

    public function getFilePathAttribute($value)
    {
        if ($value) {
            return asset('public/uploads/' . $value);
        }
    }
}
