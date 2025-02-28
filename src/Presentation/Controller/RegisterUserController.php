<?php

namespace App\Presentation\Controller;

use App\Domain\User\UseCase\RegisterUserUseCase;

class RegisterUserController
{
    private RegisterUserUseCase $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function __invoke(): void
    {
        // Obtenemos el cuerpo de la solicitud manualmente
        $data = json_decode(file_get_contents('php://input'), true);

        header('Content-Type: application/json');

        try {
            $this->registerUserUseCase->execute($data);
            http_response_code(201);
            echo json_encode(['status' => 'User registered successfully']);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}