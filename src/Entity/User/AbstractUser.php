<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\Admin\Admin;
use App\Exception\DomainException;
use App\Exception\Http\Authorization\AccessDeniedException;
use App\Model\Aggregate\AggregateRootInterface;
use App\Model\Credentials\CredentialsInterface;
use App\Model\Credentials\CredentialsTrait;
use App\Model\OptimisticLock\EditVersionEntityInterface;
use App\Model\OptimisticLock\EditVersionEntityTrait;
use App\Model\SoftDeleteable\SoftDeleteableEntityTrait;
use App\Model\Timestampable\TimestampableTrait;
use App\Model\Translatable\Languages;
use Fresh\CentrifugoBundle\User\CentrifugoUserInterface;
use Gedmo\SoftDeleteable\SoftDeleteable;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV4;

/**
 * AbstractUser.
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="abstract_users",
 *     indexes={
 *         @ORM\Index(columns={"email_confirmation_token"}),
 *         @ORM\Index(columns={"email_canonical"}),
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(columns={"email_canonical", "deleted_at"}),
 *     }
 * )
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     AbstractUser::TYPE_ADMIN="App\Entity\Admin\Admin",
 *     AbstractUser::TYPE_APPLICATION_USER="App\Entity\ApplicationUser\ApplicationUser",
 * })
 * @ORM\EntityListeners({
 *     "App\EventListener\ORM\Credentials\CredentialsListener",
 * })
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *
 * @UniqueEntity(fields={"emailCanonical", "deletedAt"})
 */
abstract class AbstractUser implements CredentialsInterface, EquatableInterface, PasswordAuthenticatedUserInterface, SoftDeleteable, UserInterface
{
    use CredentialsTrait;
    use EditVersionEntityTrait;
    use SoftDeleteableEntityTrait;
    use TimestampableTrait;

    public const TYPE_ADMIN = 'admin';
    public const TYPE_APPLICATION_USER = 'application_user';
    public const DEFAULT_TIMEZONE = 'Europe/Moscow';

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    protected UuidV4 $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected string $locale = Languages::RUSSIAN;

    /**
     * @ORM\Column(type="string", length=254, nullable=true)
     *
     * @Assert\Email(mode="strict", message="email_is_not_valid")
     * @Assert\Length(min=5, max=254)
     */
    protected ?string $email = null;

    /**
     * @ORM\Column(type="string", length=254, nullable=true)
     *
     * @Assert\Length(min=5, max=254)
     */
    protected ?string $emailCanonical = null;

    /**
     * @ORM\Column(type="boolean", name="is_email_confirmed")
     */
    protected bool $emailConfirmed = false;

    /**
     * @ORM\Column(type="string", length=120, nullable=true, unique=true)
     *
     * @Assert\Length(max=120)
     */
    protected ?string $emailConfirmationToken = null;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected ?\DateTime $emailConfirmedAt = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id = new UuidV4();
        $this->initTimestampableFields();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        if ($user instanceof Admin && !$user->isEnabled()) {
            throw new AccessDeniedException();
        }

        if ($user->getId() !== $this->getId()) {
            return false;
        }

        if ($user->getRoles() !== $this->getRoles()) {
            return false;
        }

        return $user->getEmail() === $this->getEmail();
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailConfirmed(): bool
    {
        return $this->emailConfirmed;
    }

    /**
     * @param bool $emailConfirmed
     *
     * @return self
     */
    public function setEmailConfirmed(bool $emailConfirmed): self
    {
        $this->emailConfirmed = $emailConfirmed;

        if ($this->emailConfirmed) {
            $this->emailConfirmedAt = new \DateTime('now');
        } else {
            $this->emailConfirmedAt = null;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailConfirmationToken(): ?string
    {
        return $this->emailConfirmationToken;
    }

    /**
     * @param string|null $emailConfirmationToken
     *
     * @return self
     */
    public function setEmailConfirmationToken(?string $emailConfirmationToken): self
    {
        $this->emailConfirmationToken = $emailConfirmationToken;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEmailConfirmedAt(): ?\DateTime
    {
        return $this->emailConfirmedAt;
    }

    /**
     * @param \DateTime|null $emailConfirmedAt
     *
     * @return self
     */
    public function setEmailConfirmedAt(?\DateTime $emailConfirmedAt): self
    {
        $this->emailConfirmedAt = $emailConfirmedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    /**
     * @param string|null $emailCanonical
     *
     * @return $this
     */
    public function setEmailCanonical(?string $emailCanonical): self
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    public function getEmailGuaranteed(): string
    {
        $email = $this->getEmail();

        if (!\is_string($email)) {
            throw new DomainException('Email is missed');
        }

        return $email;
    }

    public function __toString(): string
    {
        return $this->getEmailCanonical();
    }

    /**
     * @return string
     */
    abstract public function getUserIdentifier(): string;

    /**
     * @return string
     */
    abstract public function getType(): string;
}
