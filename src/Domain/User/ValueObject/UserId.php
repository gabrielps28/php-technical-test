<?php 

namespace App\Domain\User\ValueObject;

class UserId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getValue(): int
    {
        return $this->id;
    }
}
?>