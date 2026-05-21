<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'class_user');
    }
}
