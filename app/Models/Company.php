<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use softDeletes;

class Company extends Model
{
    use HasFactory, softDeletes;


    protected $fillable = [
        'name',
        'logo', 
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function roles()
    {
        return $this->hasMany(Roles::class);
    }
}