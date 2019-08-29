<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NonRecurringSchedules extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         // return parent::toArray($request);
         return [
            'id' => $this->id,
            'flight_number'=> $this->flight_number,
            'equipment'=> $this->equipment,
            'terminal' =>  $this->terminal,
            'ground_time'=>  $this->ground_time,
            'departure'=>  $this->departure,
            'customer_name'=>  $this->customer_name,
            'company_name'=>  $this->company_name,
            'start_date'=>  $this->start_date,
            'stop_date'=>  $this->stop_date,
            'created_by'=>  $this->created_by,
        ];
    }

    public function with($reuest) 
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('https://www.linkedin.com/in/jan-dave-arce-30a39a9b/')
        ];
    }
}
