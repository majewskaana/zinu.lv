<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'leftUser',
        'privatskolotajs_id',
    ];

    public function lietotajs()
    {
        return $this->belongsTo(User::class);
    }

    public function privatskolotajs()
    {
        return $this->belongsTo(PrivateTeacher::class);
    }
}
