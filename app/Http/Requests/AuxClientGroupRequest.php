<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuxClientGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('superadmin');
    }

    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'order'  => 'nullable|integer',
            'active' => 'boolean',
        ];
    }

 
}