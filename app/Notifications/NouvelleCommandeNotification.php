<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NouvelleCommandeNotification extends Notification
{
    use Queueable;

    public function __construct(public Commande $commande) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'             => 'nouvelle_commande',
            'commande_id'      => $this->commande->id,
            'numero_commande'  => $this->commande->numero_commande,
            'nom_client'       => $this->commande->nom_client,
            'montant_total'    => $this->commande->montant_total,
            'message'          => "Nouvelle commande #{$this->commande->numero_commande} de {$this->commande->nom_client}",
        ];
    }
}
