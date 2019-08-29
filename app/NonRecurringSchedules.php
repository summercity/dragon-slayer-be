<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NonRecurringSchedules extends Model
{
    public $incrementing = false;
    
    protected $fillable = [
        'flight_number',
        'equipment',
        'terminal' ,
        'ground_time',
        'departure',
        'customer_name',
        'company_name',
        'start_date',
        'stop_date',
        'created_by',
        'updated_by',
    ]; 

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($NonRecurringSchedules) {
            $NonRecurringSchedules->{$NonRecurringSchedules->getKeyName()} = (string) Str::uuid();
            $NonRecurringSchedules->created_by = Auth::user()->id;
        });

        static::updating(function ($NonRecurringSchedules) {
            $NonRecurringSchedules->updated_by = Auth::user()->id;
        });
    }
}
