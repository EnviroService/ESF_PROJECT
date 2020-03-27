<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refSign;

    /**
     * @ORM\Column(type="integer")
     */
    private $SIRET;

    /**
     * @ORM\Column(type="float")
     */
    private $numTVA;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingPostcode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $justifyDoc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operationalAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operationalCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operationalPostcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refContact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bossName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $signinDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $signupDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $erpClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $kbis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cni;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRefSign(): ?string
    {
        return $this->refSign;
    }

    public function setRefSign(string $refSign): self
    {
        $this->refSign = $refSign;

        return $this;
    }

    public function getSIRET(): ?int
    {
        return $this->SIRET;
    }

    public function setSIRET(int $SIRET): self
    {
        $this->SIRET = $SIRET;

        return $this;
    }

    public function getNumTVA(): ?float
    {
        return $this->numTVA;
    }

    public function setNumTVA(float $numTVA): self
    {
        $this->numTVA = $numTVA;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingPostcode(): ?string
    {
        return $this->billingPostcode;
    }

    public function setBillingPostcode(string $billingPostcode): self
    {
        $this->billingPostcode = $billingPostcode;

        return $this;
    }

    public function getJustifyDoc(): ?bool
    {
        return $this->justifyDoc;
    }

    public function setJustifyDoc(bool $justifyDoc): self
    {
        $this->justifyDoc = $justifyDoc;

        return $this;
    }

    public function getOperationalAddress(): ?string
    {
        return $this->operationalAddress;
    }

    public function setOperationalAddress(string $operationalAddress): self
    {
        $this->operationalAddress = $operationalAddress;

        return $this;
    }

    public function getOperationalCity(): ?string
    {
        return $this->operationalCity;
    }

    public function setOperationalCity(string $operationalCity): self
    {
        $this->operationalCity = $operationalCity;

        return $this;
    }

    public function getOperationalPostcode(): ?string
    {
        return $this->operationalPostcode;
    }

    public function setOperationalPostcode(string $operationalPostcode): self
    {
        $this->operationalPostcode = $operationalPostcode;

        return $this;
    }

    public function getRefContact(): ?string
    {
        return $this->refContact;
    }

    public function setRefContact(string $refContact): self
    {
        $this->refContact = $refContact;

        return $this;
    }

    public function getBossName(): ?string
    {
        return $this->bossName;
    }

    public function setBossName(string $bossName): self
    {
        $this->bossName = $bossName;

        return $this;
    }

    public function getSigninDate(): ?\DateTimeInterface
    {
        return $this->signinDate;
    }

    public function setSigninDate(\DateTimeInterface $signinDate): self
    {
        $this->signinDate = $signinDate;

        return $this;
    }

    public function getSignupDate(): ?\DateTimeInterface
    {
        return $this->signupDate;
    }

    public function setSignupDate(\DateTimeInterface $signupDate): self
    {
        $this->signupDate = $signupDate;

        return $this;
    }

    public function getErpClient(): ?string
    {
        return $this->erpClient;
    }

    public function setErpClient(string $erpClient): self
    {
        $this->erpClient = $erpClient;

        return $this;
    }

    public function getKbis(): ?string
    {
        return $this->kbis;
    }

    public function setKbis(string $kbis): self
    {
        $this->kbis = $kbis;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }
}