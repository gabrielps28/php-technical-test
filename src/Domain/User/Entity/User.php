<?php

namespace App\Domain\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Column(type: "string", unique: true)]
    private string $email;

    #[ORM\Column(type: "string")]
    private string $password;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    public function __construct(Name $name, Email $email, Password $password)
    {
        $this->name = $name->getValue();
        $this->email = $email->getValue();
        $this->password = $password->getValue();
        $this->createdAt = new DateTimeImmutable();
    }

    // Getters
    public function getId(): UserId {return new UserId($this->id); }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getCreatedAt(): DateTimeImmutable { return $this->createdAt; }
}