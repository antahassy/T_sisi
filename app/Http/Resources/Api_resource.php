<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Api_resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $x = 2 * 5;
        return [
            'id'            => $this->id,  
            'username'      => $this->username,  
            'test'          => $x  
        ];
    }
}
