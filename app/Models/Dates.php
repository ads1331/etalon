<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'type'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
