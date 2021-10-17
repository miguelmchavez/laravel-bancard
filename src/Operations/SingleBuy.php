<?php 

namespace Deviam\Bancard\Operations;

use Illuminate\Http\Client\Response;
use Deviam\Bancard\Petitions\{Petition, SingleBuy as SingleBuyPetition};

class SingleBuy extends Operation
{
    private static string $resource = 'vpos/api/0.3/single_buy';
    
    private string $description;
    private float $amount;

    public function __construct(string $description, float $amount)
    {
        $this->description = $description;
        $this->amount = $amount;
    }

    protected static function getResource(): string
    {
        return self::$resource;
    }

    protected function getPetition(): Petition
    {
        return new SingleBuyPetition($this->description, $this->amount);
    }

    protected function handleSuccess(Petition $petition, Response $response): void
    {
        $petition->handlePayload($response->json());
    }
}