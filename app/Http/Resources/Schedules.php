<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Schedules extends JsonResource
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
            'destination'=> $this->destination,
            'equipment'=> $this->equipment,
            'terminal' =>  $this->terminal,
            'ground_time'=>  $this->ground_time,
            'departure'=>  $this->departure,
            'repeated'=>  $this->repeated,
            'repeated_json'=>  $this->repeated_json,
            'start_date'=>  $this->start_date,
            'stop_date'=>  $this->stop_date,
            'recurring'=>  $this->recurring,
            'status'=>  $this->status,
            'created_by'=>  $this->created_by,
            'updated_by'=>  $this->updated_by,
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
