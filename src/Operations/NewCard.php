<?php 

namespace Deviam\Bancard\Operations;

use Illuminate\Http\Client\Response;
use Deviam\Bancard\Petitions\{Petition, NewCard as NewCardPetition};

class NewCard extends Operation
{
    private static string $resource = 'vpos/api/0.3/cards/new';

    private int $userId;
    private string $userCellPhone;
    private string $userMail;

    public function __construct(int $userId, string $userCellPhone, string $userMail)
    {
        $this->userId = $userId;
        $this->userCellPhone = $userCellPhone;
        $this->userMail = $userMail;
    }

    protected static function getResource(): string
    {
        return self::$resource;
    }

    protected function getPetition(): Petition
    {
        return new NewCardPetition($this->userId, $this->userCellPhone, $this->userMail);
    }

    protected function handleSuccess(Petition $petition, Response $response): void
    {
        //
    }
}