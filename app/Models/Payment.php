<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
       'payment_method'
    ];

    public function getPaymentMethodAttribute()
    {
        $value = $this->payment_way;

        // if (request()->is('api/*')) {
        //     return match ((int)$value) {
        //         1 => trans("Cash") ,
        //         2 => trans("Online") ,
        //         default => trans("Un Known") ,
        //    };
        // }

        return match ((int)$value) {
            1 => trans("Cash") ,
            2 => trans("Online") ,
            2 => trans("Pay later") ,
            default => trans("Un Known") ,
       };
    }


}
