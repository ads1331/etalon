<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'notes', 'auth_id'];

    public $timestamps = false;

    public function addedBy()
    {
        return $this->belongsTo(AuthUser::class, 'auth_id');
    }

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
        return $this->hasMany(Links::class);
    }

    public function dates()
    {
        return $this->hasMany(Dates::class);
    }
    
    public function companies()
    {
        return $this->hasMany(Company::class); 
    }
}

