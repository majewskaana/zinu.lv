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
        return $this->belongsTo(Subjects::class);
    }

    public function uzdevums()
    {
        return $this->belongsTo(Tasks::class);
    }

    public function attended()
    {
        return $this->belongsToMany(User::class, 'eksameni');
    }
}
