<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportParameterResource extends JsonResource
{
  public function toArray(Request $request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'type' => $this->type,
      'value_type' => $this->value_type,
      'value' => $this->value
    ];
  }
}