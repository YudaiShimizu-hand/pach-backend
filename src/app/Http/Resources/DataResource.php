<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'place_name' => $this->place->place_name,
            'shop_name' => $this->shop->shop_name,
            'machine_name' => $this->machine->machine_name,
            'investment' => $this->investment,
            'proceeds' => $this->proceeds,
            'created_at' => $this->created_at,
            'score' => $this->score,
        ];
    }
}
