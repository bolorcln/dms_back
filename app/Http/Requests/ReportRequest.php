<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'view_url' => 'required|string',
            'sub_menu_id' => 'required|exists:sub_menus,id',
            'manual_data_upload_flag' => 'required|boolean',
            'data_source_url' => 'nullable|required_if:manual_data_upload_flag,true|string',
            'report_upload_type_id' => 'nullable|required_if:manual_data_upload_flag,true|exists:report_upload_types,id',
            'example_file_path' => 'nullable|required_if:manual_data_upload_flag,true|string',

            'support_phone' => 'boolean',
            'support_desktop' => 'boolean',
            'support_tablet' => 'boolean',
            'hide_tabs' => 'boolean',
            'show_toolbar' => 'boolean',

            'height' => 'nullable|integer',
            'width' => 'nullable|integer',

            'is_interactive' => 'boolean',
            'is_active' => 'boolean',

            'parameters' => 'required|array|min:1',
            'parameters.*.id' => 'nullable|exists:report_parameters,id',
            'parameters.*.name' => 'required|string|max:255',
            'parameters.*.type' => ['required', Rule::in('multi', 'single')],
            'parameters.*.value_type' => ['required', Rule::in('text', 'int', 'double', 'boolean')],
            'parameters.*.value' => ['required']
        ];
    }
}
