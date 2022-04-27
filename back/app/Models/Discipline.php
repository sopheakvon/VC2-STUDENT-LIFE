<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = ['discipline_type', 'date', 'description'];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function students(){
        
        return $this->belongsTo(Student::class, 'student_id');
    }
}
