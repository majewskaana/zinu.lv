<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',          
        'is_correct',
        'task_id',    
    ];

    public function tasks()
    {
        return $this->belongsTo(Tasks::class);
    }
}
