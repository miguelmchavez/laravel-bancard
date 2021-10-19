<?php

namespace Deviam\Bancard\Petitions;

use Deviam\Bancard\Bancard;
use Deviam\Bancard\Models\{SingleBuy as SingleBuyModel, Confirmation as ConfirmationModel};

class TokenCharge extends Petition
{
    private SingleBuyModel $payload;
    private string $aliasToken;

    public function __construct(string $description, float $amount, string $aliasToken)
    {
        $payload = SingleBuyModel::create([
            'description' => $description, 
            'amount' => $amount, 
            'currency' => 'PYG'
        ]);
        $this->payload = SingleBuyModel::find($payload->id);
        $this->aliasToken = $aliasToken;
    }

    protected function token(): string
    {
        $privateKey = Bancard::privateKey();
        $token = "{$privateKey}{$this->payload->shop_process_id}charge{$this->payload->amount}{$this->payload->currency}{$this->aliasToken}";

        return hash('md5', $token);
    }

    public function getOperationPetition(): array
    {
        return [
            'public_key' => Bancard::publicKey(), 
            'operation' => [
                'token' => $this->token(), 
                'shop_process_id' => $this->payload->shop_process_id, 
                'amount' => "{$this->payload->amount}", 
                'number_of_payments' => 1, 
                'currency' => $this->payload->currency, 
                'additional_data' => $this->payload->additional_data, 
                'description' => $this->payload->description, 
                'alias_token' => $this->aliasToken
            ]
        ];
    }

    public function handlePayload(array $data = []): void
    {
        $securityInformation = $data['security_information'];
        unset($data['security_information']);
        $confirmation = array_merge($data, $securityInformation);

        ConfirmationModel::create($confirmation);
    }
}