<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'priority' => $this->priority,
                'created_at' => new DateTimeResources($this->created_at),
                'updated_at' => new DateTimeResources($this->updated_at)
            ],
            'relationship' => [
                'id' => (string) $this->user_id,
                'username' => $this->user->name,
                'email' => $this->user->email
            ]
        ];
    }
}
