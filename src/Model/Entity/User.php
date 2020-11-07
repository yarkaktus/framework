<?php

declare(strict_types=1);

namespace Model\Entity;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $birthday;

    /**
     * @var string
     */
    private $passwordHash;

    /**
     * @var Role
     */
    private $role;

    /**
     * @param int $id
     * @param string $name
     * @param string $login
     * @param string $password
     * @param string $birthday
     * @param Role $role
     */
    public function __construct(int $id, string $name, string $login, string $birthday, string $password, Role $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->birthday = $birthday;
        $this->passwordHash = $password;
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }
    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isSuperUser(): bool
    {
        $role = $this->role;

        if ($role->getType() == 'admin') {
            return true;
        }
        return false;

    }
}
