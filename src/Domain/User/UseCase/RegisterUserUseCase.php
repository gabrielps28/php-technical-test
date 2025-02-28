<?php

namespace App\Domain\User\UseCase;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\DTO\RegisterUserRequest;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use App\Domain\User\Event\UserRegisteredEvent;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;
    private array $eventHandlers = [];

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterUserRequest $request): void
    {
        // Verificar si el email ya está registrado
        $existingUser = $this->userRepository->findByEmail($request->getEmail());
        if ($existingUser) {
            throw new \InvalidArgumentException('UserAlreadyExistsException');
        }

        // Crear el nuevo usuario
        $name = new Name($request->getName());
        $email = new Email($request->getEmail());
        $password = new Password($request->getPassword());

        $user = new User($name, $email, $password);
        $this->userRepository->save($user);

        // Disparar evento de usuario registrado
        $this->dispatchEvent(new UserRegisteredEvent($user));
    }

    public function onUserRegistered(callable $handler): void
    {
        $this->eventHandlers[] = $handler;
    }

    private function dispatchEvent(UserRegisteredEvent $event): void
    {
        foreach ($this->eventHandlers as $handler) {
            $handler($event);
        }
    }
}