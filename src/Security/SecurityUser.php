<?php

declare (strict_types=1);

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SecurityUser
 * @package App\Security
 */
class SecurityUser implements AdvancedUserInterface, EquatableInterface, \Serializable
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $email;
    /**
     * @var array
     */
    private $roles;
    /**
     * @var string|null
     */
    private $password;
    /**
     * @var
     */
    private $salt;
    /**
     * @var bool
     */
    private $enabled = false;

    /**
     * SecurityUser constructor.
     * @param User $user
     * @param array $roles
     */
    public function __construct(User $user, array $roles = [])
    {
        $this->id = $user->getId()->toString();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password ?? '';
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     *
     */
    public function eraseCredentials(): void
    {
        $this->password = '';
        $this->salt = null;
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isAccountNonLocked(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        return $user instanceof self && $this->id === $user->getId();
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->salt,
            $this->roles,
            $this->enabled,
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized): void
    {
        [
            $this->id,
            $this->email,
            $this->salt,
            $this->password,
            $this->roles,
            $this->enabled
        ] = unserialize($serialized, false);
    }
}
