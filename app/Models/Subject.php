<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($subject) {
            $subject->slug = Str::of($subject->title)->slug('-');
        });

        static::updating(function ($subject) {
            $subject->slug = Str::of($subject->title)->slug('-');
        });
    }
}
