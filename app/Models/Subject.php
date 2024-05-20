<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function lectures()
    {
        return $this->hasMany(Lecture::class, "subject_id");
    }
}