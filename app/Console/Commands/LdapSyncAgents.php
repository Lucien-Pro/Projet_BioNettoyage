<?php

namespace App\Console\Commands;

use App\Models\Agent;
use Illuminate\Console\Command;
use LdapRecord\Models\ActiveDirectory\Group;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class LdapSyncAgents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ldap:sync-agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise les membres du groupe LDAP BioNettoyage vers la table des agents locale.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $groupDn = env('LDAP_AGENT_GROUP_DN');

        if (!$groupDn) {
            $this->error('LDAP_AGENT_GROUP_DN n\'est pas défini dans le fichier .env');
            return 1;
        }

        $this->info("Recherche du groupe : $groupDn");

        try {
            $group = Group::find($groupDn);

            if (!$group) {
                $this->error("Le groupe LDAP est introuvable : $groupDn");
                return 1;
            }

            $members = $group->members()->get();

            $this->info(count($members) . " membres trouvés dans le groupe.");

            foreach ($members as $ldapUser) {
                if (!$ldapUser instanceof LdapUser) {
                    continue;
                }

                $this->syncAgent($ldapUser);
            }

            $this->info('Synchronisation terminée avec succès.');
        } catch (\Exception $e) {
            $this->error('Erreur lors de la synchronisation : ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Synchronise un utilisateur LDAP avec un agent local.
     */
    protected function syncAgent(LdapUser $ldapUser)
    {
        $guid = $ldapUser->getConvertedGuid();
        $email = $ldapUser->getFirstAttribute('mail');
        $displayName = $ldapUser->getFirstAttribute('displayname') ?? $ldapUser->getName();
        
        // Tentative d'extraction du nom et prénom depuis le displayname (souvent "NOM Prénom")
        $parts = explode(' ', $displayName, 2);
        $nom = $parts[0] ?? 'Inconnu';
        $prenom = $parts[1] ?? '';

        // Génération d'initiales
        $initiales = strtoupper(substr($nom, 0, 1) . substr($prenom, 0, 1));
        if (empty($initiales)) {
            $initiales = strtoupper(substr($ldapUser->getFirstAttribute('samaccountname'), 0, 2));
        }

        $this->info("Synchronisation de l'agent : $displayName ($guid)");

        Agent::updateOrCreate(
            ['guid' => $guid],
            [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'initiales' => substr($initiales, 0, 10),
                'statut' => 'actif',
            ]
        );
    }
}
