<?php

namespace Deviam\Bancard\Petitions;

use Deviam\Bancard\Bancard;
use Deviam\Bancard\Models\SingleBuy as SingleBuyModel;

class SingleBuy extends Petition
{
    private SingleBuyModel $payload;

    public function __construct(string $description, float $amount)
    {
        $this->payload = SingleBuyModel::create([
            'description' => $description, 
            'amount' => $amount, 
            'currency' => 'PYG'
        ]);
    }

    protected function token(): string
    {
        $privateKey = Bancard::privateKey();
        $token = "{$privateKey}{$this->payload->shop_process_id}{$this->payload->amount}{$this->payload->currency}";

        return hash('md5', $token);
    }

    public function getOperationPetition(): array
    {
        return [
            'public_key' => Bancard::publicKey(), 
            'operation' => [
                'token' => $this->token(), 
                'shop_process_id' => $this->payload->shop_process_id, 
                'currency' => $this->payload->currency, 
                'amount' => "{$this->payload->amount}", 
                'additional_data' => $this->payload->additional_data, 
                'description' => $this->payload->description, 
                'return_url' => config('bancard.single_buy_return_url'), 
                'cancel_url' => config('bancard.single_buy_cancel_url')
            ]
        ];
    }

    public function handlePayload(array $body): void
    {
        $this->payload->update($body);
    }
}