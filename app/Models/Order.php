<?php

namespace App\Models;

use App\Services\FirebaseService;
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
        'floor_number' => 'integer',
        'apartment_number' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
    ];
    

    public function scopeUnpaid($query)
    {
        return $query->where('is_paid',false);
    }

    public function getAmountAttribute($value)
    {
        if (is_null($value)) {
            return 0.00;
        }

        return (float) $value;
    }
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
            default => trans("Un Known") ,
       };
        
        
    }

    public function getStatusNameAttribute()
    {
        $value = $this->status;

        // if (request()->is('api/*')) {
        //     return match ((int)$value) {
        //         1 => "Pending",
        //         2 => "On Progress",
        //         3 => "Finished",
        //         4 => "Canceled",
        //         default => "Pending" ,
        //    };
        // }

        return match ((int)$value) {
            1 => trans("Pending"),
            2 => trans("On Progress"),
            3 => trans("Finished"),
            4 => trans("Canceled"),
            default => trans("Pending") ,
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
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed()->withDefault([
            'name' => trans('No Customer'),
        ]);
    }
    public function activeCustomer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function road()
    {
        return $this->belongsTo(Road::class, 'road_id');
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

        static::updating(function ($order) {
            if ($order->road()->exists()
            ) {
                if ($order->amount != $order->getOriginal('amount') && $order->road->driver_id) {
                    $token = User::find($order->road->driver_id)->fcm_token;
                    FirebaseService::sendNotification('Amount of order was changed',[
                        'id' => $order->id,
                        'type' => 'Order amount changed',
                    ],collect([$token]));
                }
            }
            
        });
    }
}
