<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $userRoles;

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getUserName() : ? string
    {
        return $this->userName;
    }

    public function setUserName(string $userName) : self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture() : ? string
    {
        return $this->picture;
    }

    public function setPicture(? string $picture) : self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDateInscription() : ? \DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription) : self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getPassword() : ? string
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    public function getJob() : ? string
    {
        return $this->job;
    }

    public function setJob(? string $job) : self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles() : Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole) : self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole) : self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }

    public function getRoles()
    {
        $listRoles = $this->userRoles->toArray();
        foreach( $listRoles as $userRole) {
            $userRoles[] = $userRole->getValue();
        }
        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($listRoles)) {
            $userRoles[] = 'ROLE_USER';
        }
        return array_unique($userRoles);
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}
