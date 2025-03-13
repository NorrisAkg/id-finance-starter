@extends('mails.base_email')
@section('username', $loan->user->firstname . ' ' . $loan->user->lastname)
@section('content')

    <p>Bonjour,</p>
    <p>Vous avez reçu une nouvelle demande de prêt.</p>
    <ul>
        <li>Client : {{ $loan->user->fullname }}</li>
        <li>RIB : {{ $loan->rib_code }}</li>
        <li>Montant : {{ $loan->amount }}</li>
        <li>Code : {{ $loan->code }}</li>
    </ul>

@endsection
