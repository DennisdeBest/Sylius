<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\UserBundle\Provider;

use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Model\UserInterface as SyliusUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractUserProvider implements UserProviderInterface
{
    protected string $supportedUserClass = UserInterface::class;

    protected UserRepositoryInterface $userRepository;

    protected CanonicalizerInterface $canonicalizer;

    /**
     * @param string $supportedUserClass FQCN
     */
    public function __construct(
        string $supportedUserClass,
        UserRepositoryInterface $userRepository,
        CanonicalizerInterface $canonicalizer
    ) {
        $this->supportedUserClass = $supportedUserClass;
        $this->userRepository = $userRepository;
        $this->canonicalizer = $canonicalizer;
    }

    public function loadUserByUsername($username): UserInterface
    {
        $username = $this->canonicalizer->canonicalize($username);
        $user = $this->findUser($username);

        if (null === $user) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SyliusUserInterface) {
            throw new UnsupportedUserException(
                sprintf('User must implement "%s".', SyliusUserInterface::class)
            );
        }

        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        /** @var UserInterface|null $reloadedUser */
        $reloadedUser = $this->userRepository->find($user->getId());
        if (null === $reloadedUser) {
            throw new UsernameNotFoundException(
                sprintf('User with ID "%d" could not be refreshed.', $user->getId())
            );
        }

        return $reloadedUser;
    }

    abstract protected function findUser(string $uniqueIdentifier): ?UserInterface;

    public function supportsClass($class): bool
    {
        return $this->supportedUserClass === $class || is_subclass_of($class, $this->supportedUserClass);
    }
}
