<?php 

namespace Deviam\Bancard\Operations;

use Illuminate\Http\Client\Response;
use Deviam\Bancard\Petitions\{Petition, Confirmation as ConfirmationPetition};

class Confirmation extends Operation
{
    private static string $resource = 'vpos/api/0.3/single_buy/confirmations';

    private string $shopProcessId;

    public function __construct(string $shopProcessId)
    {
        $this->shopProcessId = $shopProcessId;
    }

    protected static function getResource(): string
    {
        return self::$resource;
    }

    protected function getPetition(): Petition
    {
        return new ConfirmationPetition($this->shopProcessId);
    }

    protected function handleSuccess(Petition $petition, Response $response): void
    {
        $data = $response->json();
        $petition->handlePayload($data['confirmation']);
    }
}