<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\Category;
use App\Models\User;
class Course extends Model
{

    protected $fillable = [
        'title', 
        'description',
        'slug',
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
     public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the user who created the Course.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved the Course.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
         
}
