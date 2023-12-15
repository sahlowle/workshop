<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $visible = [
        'id',
        'title',
        'quantity',
        'price',
    ];

    protected $appends = [
        'sub_total', 
    ];

    public function getSubTotalAttribute()
    {
        return $this->quantity *  $this->price;
    }


}
