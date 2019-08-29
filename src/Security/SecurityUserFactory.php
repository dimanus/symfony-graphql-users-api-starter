<?php

declare (strict_types = 1);

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SecurityUserFactory
 * @package App\Security
 */
class SecurityUserFactory implements UserLoaderInterface
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * SecurityUserFactory constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $username
     * @return UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username): UserInterface
    {
        $user = $this->repository->findUserByEmail($username);

        if ($user === null) {
            throw new UsernameNotFoundException('No user found');
        }

        return $user;
    }
}
