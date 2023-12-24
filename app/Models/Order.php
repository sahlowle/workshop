<?php

namespace App\Models;

use App\Mail\SendInvoice;
use App\Services\FirebaseService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $appends = [
        'status_name',  'type_name', 'status_color','payment_method','pdf_link','visit_date','order_visit_time'
    ];

    protected $casts = [
        'is_amount_received' => 'boolean',
        'is_customer_confirm' => 'boolean',
        'is_paid' => 'boolean',
        'is_pickup' => 'boolean',
        'status' => 'integer',
        'floor_number' => 'integer',
        'apartment_number' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
        'visit_time' =>  'datetime:Y-m-d H:i',
    ];

    
    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class, 'guarantee_id');
    }

   
    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function scopeUnpaid($query)
    {
        return $query->where([
            'is_paid' => false,
            'payment_way' => 3,
            'status' => 4
        ]);
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
            3 => trans("Pay later") ,
            default => trans("Un Known") ,
       };
    }

    public function getTypeNameAttribute()
    {
        $value = $this->type;

        return match ((int)$value) {
            1 => trans("Pick up"),
            2 => trans("On site"),
            3 => trans("Drop off"),
            default => trans("Pick up") ,
       };
        
    }

    public function getPdfLinkAttribute()
    {
        $id = $this->id;

        return route('api.orders.pdf',$id);  
    }

    public function getVisitDateAttribute()
    {
        if (! is_null($this->visit_time)) {
            return $this->visit_time->format('d.m.Y');

        }
        return $this->visit_time;
    }

    public function getOrderVisitTimeAttribute()
    {
        if (! is_null($this->visit_time)) {
            return $this->visit_time->format('H:i');

        }
        return $this->visit_time;
    }



    public function getStatusNameAttribute()
    {
        $value = $this->status;

        return match ((int)$value) {
            1 => trans("Pending"),
            2 => trans("Assigned"),
            3 => trans("Under maintenance"),
            4 => trans("Finished"),
            0 => trans("Canceled"),
            default => trans("Pending") ,
       };
        
    }

    public function getStatusColorAttribute()
    {
        $value = $this->status;
        
        return match ((int)$value) {
             1 => "text-secondary" ,
             2 => "text-info" ,
             3 => "text-warning" ,
             4 => "text-success",
             0 => "text-danger",
             default => "text-secondary" ,
        };
    }

    public function getPaymentFileAttribute($value)
    {
        if (! is_null($value)) {
            return url("")."/".$value;
        }
        return null;
    }

    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withTrashed()->withDefault([
            'name' => trans('No Customer'),
        ]);
    }

    public function pickupAddress()
    {
        return $this->hasOne(PickupAddress::class, 'order_id', 'id');
    }
    
    public function pickupOrder()
    {
        return $this->belongsTo(Order::class, 'pickup_order_ref', 'reference_no');
    }

    
    public function user()
    {
        return $this->hasOne(User::class, 'foreign_key', 'local_key');
    }

    public function scopePickup($query)
    {
        return $query->where('type',1);
    }

    public function activeCustomer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id')->withDefault(['name'=>trans("No Technician")]);
    }

    public function road()
    {
        return $this->belongsTo(Road::class, 'road_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'order_id');
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
                    $user = request()->user();

                    if ($user->hasRole('admin')) {
                        $user = User::find($order->road->driver_id);
                        $token = $user->fcm_token;
                        
                        FirebaseService::sendNotification(trans('Amount of order was changed',[],$user->lang),[
                            'id' => $order->id,
                            'type' => 'Order amount changed',
                        ],collect([$token]));

                    } elseif($user->hasRole('driver')) {
                         $tokens = User::admins()->pluck('fcm_token');
                         FirebaseService::sendNotification(trans('Amount of order was changed'),[
                            'id' => $order->id,
                            'type' => 'Order amount changed',
                         ],$tokens);
                    }
                    
                }

                if ($order->is_paid && $order->is_paid != $order->getOriginal('is_paid')) {
                    $order->load('customer');

                    // $blade = "reports.pickup";
                    // if ($order->type == 3) {
                    //     $blade = "reports.drop-off";
                    // }

                    // Mail::to($order->customer->email)->send(new SendInvoice($order,$blade));
    
                    $tokens = User::admins()->pluck('fcm_token');
    
                    FirebaseService::sendNotification(trans('You have paid order'),[
                        'id' => $order->id,
                        'type' => 'Paid Order',
                    ],$tokens);
                }
            }
            
        });

        static::updated(function ($order) {

           

        });
    }
}
