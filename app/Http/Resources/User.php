<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /*Get all data of user*/
        //return parent::toArray($request);


        /*Get specific data of user*/
        return [
            'name' => $this->name,
            'email' => $this->email,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
