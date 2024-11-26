<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'form',
    ];

    public function themes()
    {
        return $this->hasMany(Theme::class, 'macibu_prieksmets_id');
    }

    public function privatskolotaji()
    {
        return $this->belongsToMany(PrivateTeacher::class);
    }

    public function uzdevumi()
    {
        return $this->hasMany(Tasks::class, 'macibu_prieksmets_id');
    }
}
