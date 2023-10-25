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

    // protected $hidden = [
    //     'created_at','updated_at','deleted_at'
    // ];

    protected $appends = [
        'status_name', 'status_color','payment_method'
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'is_visit' => 'boolean',
    ];

    public function getPaymentMethodAttribute()
    {
        $value = $this->payment_way;
        
        return match ((int)$value) {
             1 => trans("Cash") ,
             2 => trans("Online") ,
             default => trans("Un Known") ,
        };
    }

    public function getStatusNameAttribute()
    {
        $value = $this->status;
        
        return match ((int)$value) {
             1 => "Pending",
             2 => "On Progress",
             3 => "Finished",
             4 => "Canceled",
             default => "Pending" ,
        };
    }

    public function getStatusColorAttribute()
    {
        $value = $this->status;
        
        return match ((int)$value) {
             1 => "text-secondary" ,
             2 => "text-warning" ,
             3 => "text-success" ,
             4 => "text-danger" ,
             default => "text-secondary" ,
        };
    }

    public function getPaymentFileAttribute($value)
    {
        return url("")."/".$value;
    }

    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault([
            'name' => trans('No Customer'),
        ]);
    }

    public function road()
    {
        return $this->belongsTo(Road::class, 'road_id')->withDefault([
            'name' => trans('No Customer'),
        ]);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            // $order->reference_no = 'OF-' . date("Ymd") . '-' . date("his");
            $order->reference_no = referenceNo('OF');
            $order->create_by = auth()->user()->id; 
        });
    }
}
