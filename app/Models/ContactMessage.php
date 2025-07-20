<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'message', 'is_read', 'user_id'];
    public function user(){
        return($this->belongsTo(User::class));
    }
}
