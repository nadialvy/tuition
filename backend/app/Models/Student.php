<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    public $timestamps = true;
    
    protected $fillable = [
        'nisn',
        'nis',
        'name',
        'grade_id',
        'address',
        'phone',
        'bill'
    ];
}
