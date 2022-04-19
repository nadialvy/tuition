<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    use HasFactory;

    protected $table = 'tuition';
    public $timestamps = true;

    public $fillable = [
        'generation',
        'year',
        'nominal'
    ];
}
