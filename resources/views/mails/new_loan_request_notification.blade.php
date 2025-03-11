<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de prêt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
        }
        .content {
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Logo">
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez reçu une nouvelle demande de prêt.</p>
            <ul>
                <li>Client : {{ $loan->user->fullname }}</li>
                <li>RIB : {{ $loan->rib_code }}</li>
                <li>Montant : {{ $loan->amount }}</li>
                <li>Code : {{ $loan->code }}</li>
            </ul>
            <p>Cordialement,</p>
            <p>L'équipe</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Votre Entreprise. Tous droits réservés.
        </div>
    </div>
</body>
</html>
