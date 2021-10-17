<?php 

namespace Deviam\Bancard\Operations;

use Illuminate\Http\Client\Response;
use Deviam\Bancard\Petitions\{Petition, DeleteCard as DeleteCardPetition};

class DeleteCard extends Operation
{
    protected static string $resource = 'vpos/api/0.3/users/user_id/cards';

    private static int $userId;
    private static string $aliasToken = '';

    public function __construct(int $userId, string $aliasToken)
    {
        self::$userId = $userId;
        self::$aliasToken = $aliasToken;
    }

    protected static function getResource(): string
    {
        $resource = self::$resource;
        $userId = self::$userId;

        return str_replace('user_id', $userId, $resource);
    }

    protected function getPetition(): Petition
    {
        return new DeleteCardPetition(self::$userId, self::$aliasToken);
    }

    protected function handleSuccess(Petition $petition, Response $response): void
    {
        $petition->handlePayload();
    }

    protected function getMethod(): string
    {
        return 'delete';
    }
}