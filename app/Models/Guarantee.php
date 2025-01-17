<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    protected $table = "guarantees";

    protected $guarded = [
        'id'
    ];

    protected $visible = [
        'id','name'
    ];

}
