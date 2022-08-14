<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Responsibility extends Model
{
    use HasFactory, softDeletes;

        protected $fillable = [
        'name',
        'role_id',
        ];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
}