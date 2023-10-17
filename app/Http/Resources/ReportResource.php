<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'view_url' => $this->view_url,
            'sub_menu_id' => $this->sub_menu_id,
            'sub_menu_code' => $this->subMenu->code,

            'manual_data_upload_flag' => $this->manual_data_upload_flag,
            'data_source_url' => $this->data_source_url,
            'report_upload_type_id' => $this->report_upload_type_id,
            'example_file_path' => $this->example_file_path,
            
            'support_phone' => $this->support_phone,
            'support_desktop' => $this->support_desktop,
            'support_tablet' => $this->support_tablet,
            'hide_tabs' => $this->hide_tabs,
            'show_toolbar' => $this->show_toolbar,
            'height' => $this->height,
            'width' => $this->width,
            'is_interactive' => $this->is_interactive,
            'is_active' => $this->is_active,

            'parameters' => ReportParameterResource::collection($this->parameters)
        ];
    }
}
