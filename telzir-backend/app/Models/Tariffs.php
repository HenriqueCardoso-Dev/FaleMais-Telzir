<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariffs extends Model
{
    use HasFactory;

    protected $table = 'tariffs';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'ddd_init',
        'ddd_end',
        'tariff'
    ];
}
