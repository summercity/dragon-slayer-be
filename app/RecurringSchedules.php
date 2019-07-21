<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    ]; 

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($RecurringSchedules) {
            $RecurringSchedules->{$RecurringSchedules->getKeyName()} = (string) Str::uuid();
        });
    }
}
