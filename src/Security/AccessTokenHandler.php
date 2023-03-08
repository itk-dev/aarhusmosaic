<?php

namespace App\Security;

use App\Entity\ApiUser;
use App\Repository\ApiUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private readonly ApiUserRepository $repository
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        /** @var ApiUser $accessToken */
        $accessToken = $this->repository->findBy(['token' => $accessToken]);
        if (null === $accessToken) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        // and return a UserBadge object containing the user identifier from the found token
        return new UserBadge($accessToken->getToken());
    }

}
