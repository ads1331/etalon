<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'notes'];


    public $timestamps = false;
    
    
    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    public function emails()
    {
        return $this->hasMany(Emails::class);
    }
    
    public function links()
    {
        return $this->hasmany(Links::class);
    }

    public function dates()
    {
        return $this->hasmany(Dates::class);
    }
    public function companies()
    {
        return $this->hasMany(Company::class); 
    }
}
