<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'surname',
            'contact_info',
            'city',
            'image_path',
            'material_style',
            'about_private_teacher',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'privateTeacher');
    }

    public function macibuPrieksmeti()
    {
        return $this->belongsToMany(Subjects::class, 'private_teacher_subject', 'teacher_id', 'subject_id');
    }

    public function setImagePathAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image_path'] = $value->store('images', 'public');
        }
    }
}
