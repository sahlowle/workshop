<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];

    public function getStatusAttribute($value)
    {
        return match ((int)$value) {
             1 => trans("Pending") ,
             2 => trans("On Progress") ,
             3 => trans("Finished") ,
             4 => trans("Canceled") ,
             default => trans("Pending") ,
        };
    }

    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault([
            'name' => trans('No Customer'),
        ]);
    }

    protected static function booted()
    {
        static::creating(function ($road) {
            $road->reference_no = 'OF-' . date("Ymd") . '-' . date("his");
            $road->create_by = auth()->user()->id; 
        });
    }
}
