<?php
namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationSuccessListener 
{


    private Serializer $serializer;

public function __construct(SerializerInterface $serializer)
{
    $this->serializer = $serializer;
}
/**
 * @param AuthenticationSuccessEvent $event
 */
public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
{
    $data = $event->getData();
    $user = $event->getUser();
    //dd($user);
    if (!$user instanceof UserInterface) {
        return;
    }

    $data['user'] = $this->serializer->normalize($user, null, ["groups" => ["user_authentication"] ]); 

    $event->setData($data);
    }


}