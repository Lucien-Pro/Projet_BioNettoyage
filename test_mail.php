<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\Mail::raw('Ceci est un test pour vérifier l\'envoi de mail depuis l\'application Projet_BioNettoyage.', function ($message) {
        $message->to('lucien.n@outlook.fr')
                ->subject('Test envoi mail - Projet BioNettoyage');
    });
    echo "Mail envoyé avec succès à lucien.n@outlook.fr\n";
} catch (\Exception $e) {
    echo "Erreur lors de l'envoi du mail : " . $e->getMessage() . "\n";
}
