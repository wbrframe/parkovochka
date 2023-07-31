<?php

declare(strict_types=1);

namespace App\Entity\Admin;

use App\Entity\User\AbstractUser;
use App\Exception\DomainException;
use App\Model\Blameable\BlameableInterface;
use App\Model\Blameable\BlameableTrait;
use App\Security\Role;
use Symfony\Component\Uid\UuidV4;

/**
 * Admin.
 *
 * @ORM\Entity(repositoryClass="App\Repository\Admin\AdminRepository")
 * @ORM\Table(
 *     name="admins",
 *     indexes={
 *         @ORM\Index(columns={"reset_password_confirmation_token"})
 *     }
 * )
 * @ORM\EntityListeners({
 *     "App\EventListener\ORM\Admin\AdminListener",
 *     "App\EventListener\ORM\Blameable\BlameableListener",
 *     "App\EventListener\ORM\Credentials\CredentialsListener",
 * })
 *
 * @AppAssert\Email\AdminEmailIsNotUsedByOthers()
 */
class Admin extends AbstractUser implements BlameableInterface, \Serializable
{
    use BlameableTrait;

    /**
     * @StfalconStudioAssert\Password\PasswordMeetSpecialRequirements()
     */
    private ?string $plainPassword = null;

    /**
     * @ORM\Column(name="`password`", type="string", length=255, nullable=true)
     *
     * @Assert\Length(max=255, groups={"Password"})
     */
    private ?string $password = null;

    /**
     * @ORM\Column(type="string", length=254)
     *
     * @Assert\Sequentially({
     *     @Assert\NotBlank(message="email_should_not_be_blank"),
     *     @Assert\Email(mode="strict", message="email_is_not_valid"),
     *     @Assert\Length(min=5, max=254)
     * })
     */
    protected ?string $email = null;

    /**
     * @ORM\Column(type="string", length=254)
     *
     * @Assert\Length(min=5, max=254)
     */
    protected ?string $emailCanonical = null;

    /**
     * @ORM\Column(type="string", length=120, nullable=true, unique=true)
     *
     * @Assert\Length(max=120)
     */
    private ?string $resetPasswordConfirmationToken = null;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private ?\DateTime $resetPasswordRequestedAt = null;

    /**
     * @ORM\Column(name="roles", type="json")
     *
     * @Assert\Sequentially({
     *     @Assert\Count(min="1", groups={"CreateByAdmin"}),
     *     @Assert\Choice(choices={"ROLE_ADMIN"}, multiple=true)
     * })
     */
    private array $roles = [Role::ADMIN];

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Assert\Sequentially({
     *     @Assert\NotBlank(message="first_name_should_not_be_blank", groups={"EditByAdmin"}),
     *     @Assert\Type("string"),
     *     @Assert\Length(min=1, max=100)
     * })
     */
    private ?string $firstName = null;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Assert\Sequentially({
     *     @Assert\NotBlank(message="last_name_should_not_be_blank", groups={"EditByAdmin"}),
     *     @Assert\Type("string"),
     *     @Assert\Length(min=1, max=100)
     * })
     */
    private ?string $lastName = null;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private bool $isEnabled = false;

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     *
     * @return self
     */
    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        if (!empty($plainPassword)) {
            $this->password = null;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     *
     * @return self
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     *
     * @throws DomainException
     */
    public function getUsername(): string
    {
        if (null === $this->email) {
            throw new DomainException('Email is required for username');
        }

        return $this->email;
    }

    /**
     * {@inheritdoc}
     *
     * @throws DomainException
     */
    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return self::TYPE_ADMIN;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize([
            (string) $this->id,
            $this->roles,
            $this->email,
            $this->firstName,
            $this->lastName,
            $this->locale,
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized): void
    {
        [
            $id,
            $this->roles,
            $this->email,
            $this->firstName,
            $this->lastName,
            $this->locale,
        ] = unserialize($serialized, ['allowed_classes' => true]);

        $this->id = UuidV4::fromString($id);
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getResetPasswordConfirmationToken(): ?string
    {
        return $this->resetPasswordConfirmationToken;
    }

    /**
     * @param string|null $resetPasswordConfirmationToken
     *
     * @return self
     */
    public function setResetPasswordConfirmationToken(?string $resetPasswordConfirmationToken): self
    {
        $this->resetPasswordConfirmationToken = $resetPasswordConfirmationToken;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getResetPasswordRequestedAt(): ?\DateTime
    {
        return $this->resetPasswordRequestedAt;
    }

    /**
     * @param \DateTime|null $resetPasswordRequestedAt
     *
     * @return self
     */
    public function setResetPasswordRequestedAt(?\DateTime $resetPasswordRequestedAt): self
    {
        $this->resetPasswordRequestedAt = $resetPasswordRequestedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     *
     * @return self
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return self
     */
    public function setLastName(?string $lastName = null): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     *
     * @return $this
     */
    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
