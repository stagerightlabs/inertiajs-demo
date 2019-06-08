<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ToDoItemResource extends JsonResource
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
            'hashid' => $this->hashid,
            'description' => $this->description,
            'completed_at' => $this->completed_at
                ? $this->completed_at->toAtomString()
                : null,
            'archived_at' => $this->archived_at
                ? $this->archived_at->toAtomString()
                : null,
        ];
    }
}
