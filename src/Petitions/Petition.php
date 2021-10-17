<?php 

namespace Deviam\Bancard\Petitions;

abstract class Petition
{
    abstract protected function token(): string;

    abstract public function getOperationPetition(): array;

    abstract public function handlePayload(array $data = []): void;
}