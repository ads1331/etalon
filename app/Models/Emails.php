<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'email', 'type'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
