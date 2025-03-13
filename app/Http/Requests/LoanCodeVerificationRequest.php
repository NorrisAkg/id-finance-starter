<?php

namespace App\Http\Requests;

use App\Models\Loan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class LoanCodeVerificationRequest extends FormRequest
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
            'code' => 'required',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $loan = Loan::find($this->loan_id);
            if ($loan && $loan->code !== $this->code) {
                $validator->errors()->add('client_code', 'Le code que vous avez fourni n\'est pas correct.');
            }
        });
    }

    public function messages() {
        return [
            'code.required' => 'Le code de prêt est requis.',
        ];
    }
}
