<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransferRequest extends FormRequest
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
            'id_per_sender' => 'sometimes|integer',
            'id_per_receiver' => 'sometimes|integer',
            'date_envoi' => 'sometimes|date',
            'date_recu' => 'sometimes|date',
            'patient_id' => 'sometimes|string|max:255',
            'etat_transfere' => 'sometimes|string|in:non_recu,recu', 
            'id_per_recu' => 'sometimes|integer',
        ];
    }
}
