<?php

namespace Raddit\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Raddit\AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 *
 * @UniqueEntity({"username"})
 */
class User implements UserInterface {
    /**
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="text", unique=true)
     *
     * @Assert\Length(min=3, max=25)
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+$/")
     *
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $password;

    /**
     * // bcrypt cannot handle more than 72 bytes
     * @Assert\Length(min=8, max=72, charset="8bit")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="datetimetz")
     *
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity="Moderator", mappedBy="user")
     *
     * @var Moderator[]|Collection
     */
    private $moderatorTokens;

    public function __construct() {
        $this->created = new \DateTime('@'.time());
        $this->moderatorTokens = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword() {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created) {
        $this->created = $created;
    }

    /**
     * @return Collection|Moderator[]
     */
    public function getModeratorTokens() {
        return $this->moderatorTokens;
    }

    /**
     * @param Collection|Moderator[] $moderatorTokens
     */
    public function setModeratorTokens($moderatorTokens) {
        $this->moderatorTokens = $moderatorTokens;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles() {
        // TODO
        return ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt() {
        // Salt is not needed when bcrypt is used, as the password hash contains
        // the salt.
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials() {
        $this->plainPassword = null;
    }
}
