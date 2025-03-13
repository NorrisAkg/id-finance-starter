@extends('mails.base_email')
@section('username', $user->firstname . ' ' . $user->lastname)
@section('content')
    <p>Bonjour,</p>
    <p>Un nouvel utilisateur vient de s'inscrire avec les informations suivantes :</p>
    <ul>
        <li>Email : {{ $user->email }}</li>
        <li>Nom : {{ $user->fullname }}</li>
    </ul>
    <p class="mt-2">Merci de lui fournir le code client suivant pour lui permettre de se connecter:</p>

    <p class="mt-2">Code Client : {{ $user->client_code }}</p>
@endsection
