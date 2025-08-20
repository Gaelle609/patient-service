<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
        'first_name' => 'sometimes|string|max:255',
        'last_name' => 'sometimes|string|max:255',
        'phone' => 'sometimes|string|max:255',
        'address' => 'sometimes|string|max:255',
        'emergency_contact' => 'sometimes|string|max:255',
        'matrimonial_situation' => 'sometimes|string|max:255',
        'place_of_birth' => 'sometimes|string|max:255',
        'age' => 'sometimes|integer' 
        ];
    }
}
