<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $fillable = ['title', 'description', 'price'];
    

    public function students()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
