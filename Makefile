start:
	docker-compose up -d --build
install:    
	docker-compose run --rm php composer install
	docker-compose run --rm php composer require doctrine/orm
	docker-compose run --rm php composer require --dev phpunit/phpunit
testUserEntity:
	docker-compose run --rm php vendor/bin/phpunit tests/Unit/Domain/User/Entity/UserTest.php
testUserUseCase:
	docker-compose run --rm php vendor/bin/phpunit tests/Unit/Domain/User/UseCase/RegisterUserUseCaseTest.php
testIntegration:
	docker-compose run --rm php vendor/bin/phpunit tests/Integration/Infrastructure/Persistence/Doctrine/DoctrineUserRepositoryTest.php
stop:
	docker-compose down