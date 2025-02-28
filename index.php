<?php

require_once 'vendor/autoload.php'; 

use App\Presentation\Controller\RegisterUserController;
use App\Domain\User\UseCase\RegisterUserUseCase;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

// Incluye la configuración de Doctrine para obtener el EntityManager
$em = require_once __DIR__ . '/config/doctrine-bootstrap.php'; 

// Configuración de rutas (manejo básico de rutas)
$requestUri = $_SERVER['REQUEST_URI']; 

if ($requestUri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear el repositorio de usuario (usando Doctrine)
    $userRepository = new DoctrineUserRepository($em);

    // Crear el caso de uso
    $registerUserUseCase = new RegisterUserUseCase($userRepository);

    // Crear el controlador y pasarlo el caso de uso
    $controller = new RegisterUserController($registerUserUseCase);

    // Llamar al controlador para que ejecute la lógica
    $controller();
} else {
    // En caso de ruta no encontrada (404)
    header('HTTP/1.1 404 Not Found');
    echo 'Ruta no encontrada';
}