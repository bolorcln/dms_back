<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportPermissionRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'report_id' => ['required', 'exists:reports,id'],
      'action_type' => ['required', 'string', Rule::in(['allow', 'disallow'])],
      'action' => ['required', 'array'],
      'action.*' => ['string', Rule::in(['view', 'open'])],
      'for' => ['required', 'string', Rule::in(['user', 'group'])],
      'user_id' => ['nullable', 'required_if:for,user', 'exists:users,id'],
      'group_id' => ['nullable', 'required_if:for,group', 'exists:groups,id'],

      'manual_data_upload_flag' => ['required', 'boolean'],
      'data_source_url' => ['nullable', 'required_if:manual_data_upload_flag,true', 'string'],
      'report_upload_type' => ['nullable', 'required_if:manual_data_upload_flag,true', 'exists:report_upload_types,id'],
      'allow_manual_data_upload' => ['nullable', 'required_if:manual_data_upload_flag,true', 'boolean'],

      'parameters' => ['array'],
      'parameters.*.id' => 'nullable|exists:report_parameters,id',
      'parameters.*.name' => 'required|string|max:255',
      'parameters.*.type' => ['required', Rule::in('multi', 'single')],
      'parameters.*.value_type' => ['required', Rule::in('text', 'int', 'double', 'boolean')],
      'parameters.*.value' => ['required']
    ];
  }

  public function messages()
  {
    return [
      'action_type.in' => "must be 'allow' or 'disallow'",
      'action.*.in' => "muse be 'view' or 'open'",
      'for.in' => "muse be 'user' or 'group'"
    ];
  }
}