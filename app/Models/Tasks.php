<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'theme_id',   
        'subject_id',
        'exam_id',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function eksameni()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answers::class, 'task_id');
    }
}
