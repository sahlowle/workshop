<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use  SoftDeletes;
    
    protected $guarded = [
        'id'
    ];

    protected $appends = [
        'is_disabled',
    ];

    protected $casts = [
        'postal_code' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
        // 'shipping_fee_value' => 'float(10,2)',
    ];

    public function getIsDisabledAttribute()
    {
        return $this->trashed();
    }


}
