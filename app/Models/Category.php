<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Category extends Model
{
    protected $fillable = ['name', 'slug']; // add 'slug' here

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
