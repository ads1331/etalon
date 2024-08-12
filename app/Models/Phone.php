<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'phones';
    protected $fillable = ['user_id', 'phone', 'type'];
    public $timestamps = false;
   
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
