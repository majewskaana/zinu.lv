<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'tema_id',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function eksameni()
    {
        return $this->hasMany(Exam::class, 'uzdevums_id');
    }
}
