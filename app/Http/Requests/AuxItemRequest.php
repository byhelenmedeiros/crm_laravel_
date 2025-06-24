<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuxItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('manage-aux-data');
    }

    public function rules(): array
    {
        $typeKey = $this->route('typeKey');

        $rules = [
            'name'  => 'required|string|max:255',
            'order' => 'nullable|integer',
            'active'=> 'boolean',
        ];

        // Regras para campos pai conforme tipo
        return match ($typeKey) {
            'districts' => array_merge($rules, [
                'parent_id' => 'required|exists:aux_countries,id',
            ]),

            'municipalities' => array_merge($rules, [
                'parent_id' => 'required|exists:aux_districts,id',
            ]),

            default => $rules,
        };
    }

    public function prepareForValidation()
    {
        $this->merge([
            'active' => $this->boolean('active'),
        ]);
    }
}