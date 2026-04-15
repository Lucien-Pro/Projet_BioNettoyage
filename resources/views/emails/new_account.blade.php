<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur BioNettoyage</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .credentials {
            background-color: #f9f9f9;
            border-left: 4px solid #3498db;
            padding: 20px;
            margin: 20px 0;
        }
        .footer {
            background-color: #ecf0f1;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue sur BioNettoyage</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $user->name }},</p>
            <p>Un compte a été créé pour vous sur la plateforme <strong>BioNettoyage</strong> par un administrateur.</p>
            
            <p>Voici vos identifiants de connexion temporaires :</p>
            
            <div class="credentials">
                <p><strong>Email :</strong> {{ $user->email }}</p>
                <p><strong>Mot de passe temporaire :</strong> {{ $password }}</p>
            </div>
            
            <p>Pour des raisons de sécurité, il vous sera demandé de modifier ce mot de passe lors de votre première connexion.</p>
            
            <a href="{{ url('/login') }}" class="button" style="color: #ffffff;">Se connecter à BioNettoyage</a>
            
            <p>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet e-mail.</p>
            
            <p>Cordialement,<br>L'équipe BioNettoyage</p>
        </div>
        <div class="footer">
            <p>Ceci est un message automatique, merci de ne pas y répondre.</p>
            <p>&copy; {{ date('Y') }} BioNettoyage</p>
        </div>
    </div>
</body>
</html>
