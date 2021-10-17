<?php 

namespace Deviam\Bancard\Operations;

use Illuminate\Http\Client\Response;
use Deviam\Bancard\Petitions\{Petition, ListCards as ListCardsPetition};

class ListCards extends Operation
{
    private static string $resource = 'vpos/api/0.3/users/user_id/cards';
    private static int $userId;

    public function __construct(int $userId)
    {
        self::$userId = $userId;
    }

    protected static function getResource(): string
    {
        $resource = self::$resource;
        $userId = self::$userId;

        return str_replace('user_id', $userId, $resource);
    }

    protected function getPetition(): Petition
    {
        return new ListCardsPetition(self::$userId);
    }

    protected function handleSuccess(Petition $petition, Response $response): void
    {
        $petition->handlePayload($response->json());
    }
}