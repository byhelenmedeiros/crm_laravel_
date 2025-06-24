<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuxMunicipalityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('superadmin');
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'parent_id' => 'required|exists:aux_districts,id',
            'order'     => 'nullable|integer',
            'active'    => 'boolean',
        ];
    }
 
}