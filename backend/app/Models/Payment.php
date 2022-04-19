<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    public $timestamps = true;

    protected $fillable = [
        'officer_id',
        'student_id',
        'payment_date',
        'tuition_month',
        'tuition_year',
    ];
}
