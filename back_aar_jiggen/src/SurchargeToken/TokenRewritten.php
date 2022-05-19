<?php
namespace App\SurchargeToken;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class TokenRewritten
{
    public function updateJwtData(JWTCreatedEvent $event)
    {
        // On récupère l'utilisateur
        $user = $event->getUser();

        // On enrichit le data du Token
        $data = $event->getData();

        $data['statut'] = $user->getStatut();
        $data['prenom'] = $user->getPrenom();
        $data['nom'] = $user->getNom();
        $data['photo'] = $user->getPhoto();
        $data['id'] = $user->getId();
        if ($user->getProfil()->getLibelle() == "ADMIN") {
            $data['firstConnexion'] = $user->getFirstConnexion();
        }

        $event->setData($data);
    }
}