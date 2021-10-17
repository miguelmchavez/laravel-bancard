<?php 

namespace Deviam\Bancard\Operations;

use Illuminate\Http\Client\Response;
use Deviam\Bancard\Petitions\{Petition, TokenCharge as TokenCargePetition};

class TokenCharge extends Operation
{
    private static string $resource = 'vpos/api/0.3/charge';

    private string $description;
    private float $amount;
    private string $aliasToken;

    public function __construct(string $description, float $amount, string $aliasToken)
    {
        $this->description = $description;
        $this->amount = $amount;
        $this->aliasToken = $aliasToken;
    }

    protected static function getResource(): string
    {
        return self::$resource;
    }

    protected function getPetition(): Petition
    {
        return new TokenCargePetition($this->description, $this->amount, $this->aliasToken);
    }

    protected function handleSuccess(Petition $petition, Response $response): void
    {
        $data = $response->json();
        $petition->handlePayload($data['confirmation']);
    }
}