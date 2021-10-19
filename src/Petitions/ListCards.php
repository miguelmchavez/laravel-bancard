<?php

namespace Deviam\Bancard\Petitions;

use Deviam\Bancard\Bancard;
use Deviam\Bancard\Models\Card as CardModel;

class ListCards extends Petition
{
    private $payload;

    public function __construct(int $userId)
    {
        $this->payload = $userId;
    }

    protected function token(): string
    {
        $privateKey = Bancard::privateKey();
        $token = "{$privateKey}{$this->payload}request_user_cards";

        return hash('md5', $token);
    }

    public function getOperationPetition(): array
    {
        return [
            'public_key' => Bancard::publicKey(), 
            'operation' => [
                'token' => $this->token()
            ]
        ];
    }

    public function handlePayload(array $data = []): void
    {
        foreach ($data['cards'] as $card) {
            $card['active'] = true;

            CardModel::withoutGlobalScopes()
                ->where('user_id', $this->payload)
                ->where('card_id', $card['card_id'])
                ->update($card);
        }
    }
}