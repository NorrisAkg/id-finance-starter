@extends('mails.base_email')
@section('username', $loan->user->firstname . ' ' . $loan->user->lastname)
@section('content')

    <p>Bonjour,</p>
    <p>Vous avez reçu un nouveau code pour la validation du transfert de {{ $loan->user->fullname }}.</p>
    <ul>
        <li>Client : {{ $loan->user->fullname }}</li>
        <li>RIB : {{ $loan->rib_code }}</li>
        <li>Montant : {{ $loan->amount }}</li>
        <li>Code : {{ $loan->code }}</li>
    </ul>

@endsection
