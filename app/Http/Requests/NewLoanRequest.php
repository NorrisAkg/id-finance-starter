<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewLoanRequest extends FormRequest
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
            'amount' => ['required', 'numeric'],
            'rib_code' => ['required'],
            'reason' => ['nullable', 'string'],
            // 'user_id' => ['required', 'integer', 'exists:users,id'],
            function ($attribute, $value, $fail) {
                $user = $this->user();

                if ($user->loans()->where('status', 'pending')->exists()) {
                    $fail('Vous avez déjà un prêt en cours.');
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Le montant est obligatoire',
            'amount.numeric' => 'Le montant doit être un nombre',
            'rib_code.required' => 'Le RIB est obligatoire',
        ];
    }
}
