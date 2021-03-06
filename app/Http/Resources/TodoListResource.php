<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'hashid' => $this->hashid,
            'items' => $this->whenLoaded('items', function() {
                return ToDoItemResource::collection($this->items);
            })
        ];
    }
}
