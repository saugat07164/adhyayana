<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
class Chapter extends Model
{
    public $fillable = ['unit_id', 'title', 'video_url', 'content', 'position', 'duration_in_minutes'];
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
