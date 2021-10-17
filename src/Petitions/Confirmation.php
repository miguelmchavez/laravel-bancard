<?php

namespace Deviam\Bancard\Petitions;

use Deviam\Bancard\Bancard;
use Deviam\Bancard\Models\Confirmation as ConfirmationModel;

class Confirmation implements Petition
{
    private $payload;

    public function __construct(string $shopProcessId)
    {
        $this->payload = $shopProcessId;
    }

    protected function token(): string
    {
        $privateKey = Bancard::privateKey();
        $token = "{$privateKey}{$this->payload}get_confirmation";
    }

    public function getOperationPetition(): array
    {
        return [
            'public_key' => Bancard::publicKey(), 
            'operation' => [
                'token' => $this->token(), 
                'shop_process_id' => $this->payload
            ]
        ];
    }

    public function handlePayload(array $confirmation): void
    {
        $securityInformation = $confirmation['security_information'];
        unset($confirmation['security_information']);
        $confirmation = array_merge($confirmation, $securityInformation);

        ConfirmationModel::create($confirmation);
    }
}