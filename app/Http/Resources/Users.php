<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Users extends JsonResource
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
            'name'=> $this->name,
            'email'=> $this->email,
            'computer_number'=> $this->computer_number,
            'password'=> $this->password,
            'status_description' =>  $this->status_description,
            'online'=>  $this->online,
            'active'=>  $this->active,
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
