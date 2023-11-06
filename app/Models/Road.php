<?php

namespace App\Models;

use App\Services\FirebaseService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $appends = [
        'status_name','status_color'
    ];

    public function getStatusColorAttribute()
    {
        $value = $this->status;
        
        return match ((int)$value) {
             1 => "text-secondary" ,
             2 => "text-warning" ,
             3 => "text-success" ,
             default => "text-secondary" ,
        };
    }

    public function getStatusNameAttribute()
    {
        $value = $this->status;
        
        return match ((int)$value) {
             1 => trans("Opened") ,
             2 => trans("Assigned") ,
             3 => trans("Finished") ,
             default => trans("Pending") ,
        };
    }

    
    public function orders()
    {
        return $this->hasMany(Order::class, 'road_id');
    }

    
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    protected static function booted()
    {
        static::creating(function ($road) {
            // $road->reference_no = 'RF-' . date("Ymd") . '-' . date("his");
            $road->reference_no = referenceNo('RF');
            $road->create_by = auth()->user()->id; 

            if (! is_null($road->driver_id)) {
                $road->status = 2; // on progress

                $user = User::find($road->driver_id);
                $token = $user->fcm_token;

                FirebaseService::sendNotification(trans('You have a new route',[], $user->lang),[
                    'id' => $road->id,
                    'type' => 'New Route',
                ],collect([$token]));

                // $road->orders()->update([ 'status' => 2]);
            }
        });

        static::updating(function ($road) {
            $status = (int)$road->status;

            if ($status == 1 && ! is_null($road->driver_id)) {
                $road->status = 2; // on progress
                $token = User::find($road->driver_id)->fcm_token;

                FirebaseService::sendNotification(trans('You have a new route'),[
                    'id' => $road->id,
                    'type' => 'New Route',
                ],collect([$token]));
            } elseif ($road->wasChanged('driver_id')) {
                $token = User::find($road->driver_id)->fcm_token;

                FirebaseService::sendNotification(trans('You have a new route'),[
                    'id' => $road->id,
                    'type' => 'New Route',
                ],collect([$token]));
            }

            if ($status == 3) {
                $tokens = User::admins()->pluck('fcm_token');

                FirebaseService::sendNotification(trans('You have a finished route'),[
                    'id' => $road->id,
                    'type' => 'Route Number '.$road->reference_no.' has finished',
                ],$tokens);
            }

            if (is_null($road->driver_id)) {
                $road->status = 1; // pending
            }
        });

    }
}
