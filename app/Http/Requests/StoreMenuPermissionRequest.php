<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuPermissionRequest extends FormRequest
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
            'menu_id' => ['required', 'exists:menus,id'],
            'action_type' => ['required', 'string', Rule::in(['allow', 'disallow'])],
            'action' => ['required', 'array'],
            'action.*' => ['string', Rule::in(['view', 'open'])],
            'for' => ['required', 'string', Rule::in(['user', 'group'])],
            'user_id' => ['nullable', 'required_if:for,user', 'exists:users,id'],
            'group_id' => ['nullable', 'required_if:for,group', 'exists:groups,id']
        ];
    }

    public function messages()
    {
        return [
            'action_type.in' => "must be 'allow' or 'disallow'",
            'action.*.in' => "must be 'view' or 'open'",
            'for.in' => "must be 'user' or 'group'"
        ];
    }
}
