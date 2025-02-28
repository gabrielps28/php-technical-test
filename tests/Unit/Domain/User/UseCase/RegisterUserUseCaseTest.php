<?php

namespace App\Tests\Unit\Domain\User\UseCase;

use App\Domain\User\UseCase\RegisterUserUseCase;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\Event\UserRegisteredEvent;
use App\Domain\User\DTO\RegisterUserRequest;
use PHPUnit\Framework\TestCase;

class RegisterUserUseCaseTest extends TestCase
{
    public function testRegisterUser(): void
    {
        // Mock del repositorio
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('findById')->willReturn(null);

        // Caso de uso
        $registerUserUseCase = new RegisterUserUseCase($userRepository);

        // Registramos un manejador de eventos simple
        $eventHandlerCalled = false;
        $registerUserUseCase->onUserRegistered(function (UserRegisteredEvent $event) use (&$eventHandlerCalled) {
            $eventHandlerCalled = true;
            $this->assertInstanceOf(User::class, $event->getUser());
        });


        $registerUserRequest = new RegisterUserRequest('John Doe', 'john@example.com', 'Password123!');

        $registerUserUseCase->execute($registerUserRequest);

        // Verificamos que el evento se disparó
        $this->assertTrue($eventHandlerCalled);
    }
}