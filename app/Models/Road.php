<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    
    public function orders()
    {
        return $this->hasMany(Order::class, 'road_id');
    }

    
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id')->withDefault([
            'name' => trans('No Driver'),
        ]);
    }

    protected static function booted()
    {
        static::creating(function ($road) {
            // $road->reference_no = 'RF-' . date("Ymd") . '-' . date("his");
            $road->reference_no = referenceNo('RF');
            $road->create_by = auth()->user()->id; 
        });
    }
}
