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

    public function papers()
    {
        return $this->hasMany(Paper::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
