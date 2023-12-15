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
        'is_disabled',"unique_name"
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

    public function getNameAttribute($value)
    {
        if (is_null($value) || empty($value)) {
            return $this->company_name;     
        }

        return $value;
    }

    public function getUniqueNameAttribute()
    {
        $name = $this->name;

        if (is_null($name) || empty($name)) {
           $name = $this->company_name;
        }
        return $name ." (". $this->phone.")";
    }


}
