<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'mobile_phone' => 'nullable|string|max:255',
            'piece_number' => 'required|string|max:255',
            // 'identifiant' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'firstname' => 'Le prénom est obligatoire.',
            'lastname' => 'Le nom est obligatoire.',
            'email' => 'L\'adresse email est obligatoire.',
            'address' => 'L\'adresse est obligatoire.',
            'postal_code' => 'Le code postal est obligatoire.',
            'city' => 'La ville est obligatoire.',
            'country.required' => 'Le pays est obligatoire.',
            // 'country_id.exists' => 'Le pays n\'existe pas.',
            'telephone' => 'Le téléphone est obligatoire.',
            // 'mobile_phone' => 'Le téléphone mobile est obligatoire.',
            'piece_number' => 'Le numéro de pièce est obligatoire.',
            // 'identifiant' => 'L\'identifiant est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit avoir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ];
    }
}
