<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RecurringSchedules extends Model
{
    public $incrementing = false;
    
    protected $fillable = [
        'flight_number',
        'destination',
        'equipment',
        'terminal' ,
        'ground_time',
        'departure',
        'repeated',
        'repeated_json',
        'start_date',
        'stop_date',
        'created_by',
        'updated_by',
    ]; 

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($RecurringSchedules) {
            $RecurringSchedules->{$RecurringSchedules->getKeyName()} = (string) Str::uuid();
            $RecurringSchedules->created_by = Auth::user()->id;
        });

        static::updating(function ($RecurringSchedules) {
            $RecurringSchedules->updated_by = Auth::user()->id;
        });
    }
}
