<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $table = 'officer';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'officer_name',
        'level',
    ];
}
