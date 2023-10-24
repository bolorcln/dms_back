<?php

namespace App\Http\Resources;

use App\Http\Requests\GroupRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportPermissionResource extends JsonResource
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
            'report_id' => $this->report_id,
            'report' => new ReportResource($this->whenLoaded('report')),
            'action' => explode(',', $this->action),
            'for' => $this->for,
            'user_id' => $this->user_id,
            $this->mergeWhen(!is_null($this->user_id), [
                'user' => new UserResource($this->whenLoaded('user')),
            ]),
            'group_id' => $this->group_id,
            $this->mergeWhen(!is_null($this->group_id), [
                'group' => new GroupResource($this->whenLoaded('group'))
            ]),
            'manual_data_upload_flag' => $this->manual_data_upload_flag,
            'data_source_url' => $this->data_source_url,
            'report_upload_type' => $this->report_upload_type_id,
            'allow_manaul_data_upload' => $this->allow_manual_data_upload,

            'parameters' => ReportParameterResource::collection($this->parameters)
        ];
    }
}
