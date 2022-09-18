<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function setHeaderImageAttribute($value)
    {
        if ($value) {
            $this->attributes['header_image'] = str_replace(' ', '_', $value);
        }
    }

    public function getHeaderImageAttribute($value)
    {
        if ($value) {
            return asset('public/uploads/' . $value);
        }
    }
}
