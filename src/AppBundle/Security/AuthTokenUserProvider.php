<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManager;

class AuthTokenUserProvider implements UserProviderInterface
{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAuthToken($authTokenHeader)
    {
        $accessToken = $this->em->getRepository('AppBundle\Entity\Crowding\User')->findOneByPassword($authTokenHeader);
        if ($accessToken)
        {
            return $accessToken;
        }
        return null;
    }

    public function loadUserByUsername($email)
    {
        return $this->userRepository->findByEmail($email);
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'AppBundle\Entity\Crowding\User' === $class;
    }
}