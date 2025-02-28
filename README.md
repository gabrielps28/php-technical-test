# Proyecto con Docker y PHP

Este proyecto utiliza Docker para gestionar el entorno de desarrollo y ejecución de una aplicación PHP. A continuación, se detallan los pasos para configurar y ejecutar el proyecto.

## Requisitos Previos

- Docker
- Docker Compose

## Configuración del Proyecto

**Clona el repositorio**
   git clone <URL_DEL_REPOSITORIO>
   cd <DIRECTORIO_DEL_PROYECTO>

## Construye y levanta los contenedores
**Ejecuta el siguiente comando para construir y levantar los contenedores en segundo plano**:
    make start

## Instala las dependencias de Composer
    make install

## Ejecución de Pruebas

**El proyecto incluye pruebas unitarias y de integración. Puedes ejecutar las pruebas de la siguiente manera**:

**Pruebas de la entidad User**:

    make testUserEntity

Esto ejecutará las pruebas unitarias para la entidad User.

**Pruebas del caso de uso RegisterUser**:

    make testUserUseCase
    
Esto ejecutará las pruebas unitarias para el caso de uso RegisterUser.

**Pruebas de integración con Doctrine**:

    make testIntegration
Esto ejecutará las pruebas de integración para el repositorio DoctrineUserRepository.

## Prueba Solicitud HTTP

**Cómo probarlo:**
**En tu navegador o con Postman:**
**Realiza una solicitud POST a http://localhost/register.**
**Asegúrate de enviar un cuerpo JSON con los datos del usuario en la solicitud, por ejemplo:**

    {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "Password123!"
    }
