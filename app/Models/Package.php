<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    protected $fillabel = [
        'name',
        'description',
        'price',
        'sanctions',
        'active',
    ];
}