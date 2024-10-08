<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    public $fillable = ['user_id', 'name', 'address'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
