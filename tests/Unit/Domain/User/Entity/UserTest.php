<?php

namespace App\Tests\Unit\Domain\User\Entity;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $name = new Name('John Doe');
        $email = new Email('john@example.com');
        $password = new Password('Password123!');

        $user = new User($name, $email, $password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail());
        $this->assertTrue(password_verify('Password123!', $user->getPassword())); 
    }

    public function testUserImmutable(): void
    {
        $this->expectException(\Error::class);

        $name = new Name('John Doe');
        $email = new Email('john@example.com');
        $password = new Password('Password123!');

        $user = new User($name, $email, $password);

        $user->name = new Name('Jane Doe');
    }

    public function testInvalidName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Name('Jo');
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('invalid-email');
    }

    public function testWeakPassword(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Password('weak');
    }
}
