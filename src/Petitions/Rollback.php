<?php

namespace Deviam\Bancard\Petitions;

use Deviam\Bancard\Bancard;
use Deviam\Bancard\Models\Rollback as RollbackModel;

class Rollback implements Petition
{
    private $payload;

    public function __construct(string $shopProcessId)
    {
        $this->payload = $shopProcessId;
    }

    protected function token(): string
    {
        $privateKey = Bancard::privateKey();
        $token = "{$privateKey}{$this->payload}rollback0.00";

        return hash('md5', $token);
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
        $message = $confirmation['messages'][0] ?? [];

        RollbackModel::create([
            'shop_process_id' => $this->payload, 
            'status' => $confirmation['status'], 
            'key' => $message['key'] ?? '-', 
            'level' => $message['level'] ?? '-', 
            'dsc' => $message['dsc'] ?? '-'
        ]);
    }
}