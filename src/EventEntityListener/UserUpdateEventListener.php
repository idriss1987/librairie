<?php

namespace App\EventEntityListener;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs as EventLifecycleEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserUpdateEventListener{
    private $encryptSecret;

    public function __construct(string $encryptSecret)
    {
        $this->encryptSecret = $encryptSecret;
    }

    public function preUpdate(User $user,LifecycleEventArgs $event)
    {
    // on declare l'algorithme de cryptage 
    $cipher = "aes-256-gcm";
    //on declare la clé de cryptage
    $key=$this->encryptSecret;
    // on declare le vecteur d'initialisation
    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $iv = base64_encode($user->getSecretIV());
    // on memorise le vecteur d'intialisation
    // $user->setSecretIV(base64_encode($iv));
    // On crypte le nom de l'utilisateur
    if (!is_null($user->getName()))
     {
       $encodeName = openssl_encrypt($user->getName(),$cipher,$key,0,$iv,$tag);
       $encodeName = base64_encode($tag.$encodeName);
       $user->setName($encodeName);
    }
    }
}