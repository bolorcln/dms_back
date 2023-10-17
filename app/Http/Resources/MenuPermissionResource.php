<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'menu_id' => $this->menu_id,
            'menu' => new MenuListingResource($this->whenLoaded('menu')),
            'action_type' => $this->action_type,
            'action' => explode(',', $this->action),
            'for' => $this->for,
            'user_id' => $this->user_id,
            'group_id' => $this->group_id
        ];
    }
}
