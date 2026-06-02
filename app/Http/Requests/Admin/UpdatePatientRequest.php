<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'allergies' => 'nullable|string|max:255',
            'chronic_conditions' => 'nullable|string|max:255',
            'surgical_history' => 'nullable|string|max:255',
            'family_history' => 'nullable|string|max:255',
            'blood_type_id' => 'nullable|integer|exists:blood_types,id',
            'observations' => 'nullable|string|max:500',
            'emergency_contact_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\(\)\s]+$/'],
            'emergency_contact_relationship' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/'],
        ];
    }

    public function attributes(): array
    {
        return [
            'allergies' => 'alergias',
            'chronic_conditions' => 'enfermedades crónicas',
            'surgical_history' => 'antecedentes quirúrgicos',
            'family_history' => 'antecedentes familiares',
            'blood_type_id' => 'tipo de sangre',
            'observations' => 'observaciones',
            'emergency_contact_name' => 'nombre de contacto de emergencia',
            'emergency_contact_phone' => 'teléfono de contacto de emergencia',
            'emergency_contact_relationship' => 'relación con el contacto',
        ];
    }

    public function messages(): array
    {
        return [
            'blood_type_id.exists' => 'El tipo de sangre seleccionado no es válido.',
            'blood_type_id.integer' => 'El tipo de sangre seleccionado no es válido.',
            'emergency_contact_name.regex' => 'El nombre del contacto solo puede contener letras y espacios.',
            'emergency_contact_phone.regex' => 'El teléfono solo puede contener números, espacios, +, - y paréntesis.',
            'emergency_contact_phone.max' => 'El teléfono no debe exceder 20 caracteres.',
            'emergency_contact_relationship.regex' => 'La relación solo puede contener letras y espacios.',
            'observations.max' => 'Las observaciones no deben exceder 500 caracteres.',
            '*.max' => 'El campo :attribute no debe exceder :max caracteres.',
        ];
    }
}
