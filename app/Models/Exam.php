<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'gads',
        'limenis',
        'macibu_prieksmets_id',
        'uzdevums_id',
    ];

    public function macibuPrieksmets()
    {
        return $this->belongsTo(Subjects::class, 'macibu_prieksmets_id');
    }

    public function uzdevums()
    {
        return $this->hasMany(Tasks::class, 'exam_id');
    }

    public function attended()
    {
        return $this->belongsToMany(User::class, 'eksameni');
    }
}
