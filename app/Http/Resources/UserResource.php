<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'first_name' => $this->profile->first_name,
            'last_name' => $this->profile->last_name,
            'avatar_path' => $this->profile->avatar_path,
            'posts_count' => $this->posts->count(), //TODO вигадати як перенести в профайл (не факт)
            'lat' => $this->profile->lat, //TODO вигадати як перенести в профайл
            'lng' => $this->profile->lng, //TODO вигадати як перенести в профайл
        ];
    }
}
