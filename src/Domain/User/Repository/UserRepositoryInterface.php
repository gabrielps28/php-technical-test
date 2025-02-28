<?php

    namespace App\Domain\User\Repository;

    use App\Domain\User\Entity\User;
    use App\Domain\User\ValueObject\UserId;

    interface UserRepositoryInterface
    {
        public function save(User $user): void;
        public function findById(UserId $id): ?User;
        public function delete(UserId $id): void;
        public function findByEmail(string $email): ?User;
    }

?>