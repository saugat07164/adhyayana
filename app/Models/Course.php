<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\Category;
class Course extends Model
{

    protected $fillable = [
        'title', 
        'description', 
        'thumbnail_path', 
        'price', 
        'is_free', 
        'category_id', 
        'instructor_id', 
        'created_by', 
        'approved_by', 
        'status',
    
    ];
    
     public function units()
    {
        return $this->hasMany(Unit::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
         
}
