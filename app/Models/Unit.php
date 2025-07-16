<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Chapter;
class Unit extends Model
{
   protected $fillable = ['course_id', 'title', 'position'];
   public function course(){
    return $this->belongsTo(Course::class);
   }
   public function chapters(){
    return $this->hasMany(Chapter::class);
   }
}
