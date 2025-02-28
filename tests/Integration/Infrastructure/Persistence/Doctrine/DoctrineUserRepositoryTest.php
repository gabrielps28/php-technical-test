<?php

namespace App\Tests\Integration\Infrastructure\Persistence\Doctrine;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManagerInterface $em;
    private DoctrineUserRepository $repository;

    protected function setUp(): void
    {

        $this->em = require dirname(__DIR__, 5) . '/config/doctrine-bootstrap.php';
        $this->repository = new DoctrineUserRepository($this->em);

        $schemaTool = new SchemaTool($this->em);
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();

        $connection = $this->em->getConnection();
        $schemaManager = $connection->createSchemaManager();
        if (!$schemaManager->tablesExist(['users'])) {
            $schemaTool->dropDatabase();
            $schemaTool->createSchema($metadata);
        }
    }

    public function testSaveAndFindUser(): void
    {

        $name = new Name('John Doe');
        $email = new Email('john2@example.com');
        $password = new Password('Password123!');
        $user = new User($name, $email, $password);

        $this->repository->save($user);
        $this->em->flush();

        $this->em->clear(); 

        $userId = $user->getId();
        $this->assertNotNull($userId);

        $foundUser = $this->repository->findById($userId);

        $this->assertNotNull($foundUser);
        $this->assertEquals($userId->getValue(), $foundUser->getId()->getValue());
        $this->assertEquals('John Doe', $foundUser->getName());
        $this->assertEquals('john2@example.com', $foundUser->getEmail());
    }
}