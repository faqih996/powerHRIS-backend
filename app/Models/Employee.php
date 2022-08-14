<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Employee extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'email',
        'age',
        'gender',
        'phone',
        'photo',
        'company_id',
        'team_id',
        'role_id',
        'is_verified',
        'verified_at'
    ];

    public function teams()
    {
        return $this->belongsTo(Team::class);
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }
}