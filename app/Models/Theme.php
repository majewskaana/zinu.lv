<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'macibu_prieksmets_id',
    ];

    public function macibuPrieksmets()
    {
        return $this->belongsTo(Subjects::class);
    }

    public function uzdevumi()
    {
        return $this->hasMany(Tasks::class, 'tema_id');
    }
}
