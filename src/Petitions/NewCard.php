<?php

namespace Deviam\Bancard\Petitions;

use Deviam\Bancard\Bancard;
use Deviam\Bancard\Models\Card;

class NewCard extends Petition
{
    private Card $payload;

    public function __construct(int $userId, string $userCellPhone, string $userMail)
    {
        $payload = Card::create([
            'user_id' => $userId, 
            'user_cell_phone' => $userCellPhone, 
            'user_mail' => $userMail
        ]);
        $this->payload = Card::withoutGlobalScopes()->find($payload->id);
    }

    protected function token(): string
    {
        $privateKey = Bancard::privateKey();
        $token = "{$privateKey}{$this->payload->card_id}{$this->payload->user_id}request_new_card";

        return hash('md5', $token);
    }

    public function getOperationPetition(): array
    {
        return [
            'public_key' => Bancard::publicKey(), 
            'operation' => [
                'token' => $this->token(), 
                'card_id' => $this->payload->card_id, 
                'user_id' => $this->payload->user_id, 
                'user_cell_phone' => $this->payload->user_cell_phone, 
                'user_mail' => $this->payload->user_mail, 
                'return_url' => config('bancard.new_card_return_url')
            ]
        ];
    }
}