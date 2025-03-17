<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class IncreaseBalanceRequest extends FormRequest
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
            'client_id' => ['required', 'exists:users,id'],
            'label' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
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
            /** @var User $user */
            $user = User::where('id', $this->client_id)->first();

            // if($user->loans->count() == 0){
            //     $validator->errors()->add('client_id', 'L\'utilisateur n\'a aucun prêt en cours.');
            // }

            // SI le montant résultant de l'opération est supérieur au smontant du prêt demandé par l'utilisateur
                // Retourner un message d'erreur
            // if($this->amount + $user->balance > $user->loans()->first()?->amount){
            //     $validator->errors()->add('amount', 'Avec ce montant, la balance de l\'utilisateur sera supérieure au montant du prêt demandé.');
            // }
        });
    }

    public function messages()
    {
        return [
            'client_id.required' => 'L\'utilisateur est requis.',
            'label.required' => 'Le label est requis.',
            'amount.required' => 'Le montant est requis.',
        ];
    }
}
