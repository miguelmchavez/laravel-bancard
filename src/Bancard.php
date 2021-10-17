<?php 

namespace Deviam\Bancard;

use Deviam\Bancard\Operations\{
    SingleBuy, 
    NewCard, 
    ListCards, 
    DeleteCard, 
    TokenCharge, 
    Confirmation, 
    Rollback
};
use Illuminate\Http\Client\Response;

class Bancard
{
    public static string $production = 'https://vpos.infonet.com.py';
    public static string $staging = 'https://vpos.infonet.com.py:8888';
    public static string $script = 'checkout/javascript/dist/bancard-checkout-3.0.0.js';

    public static function isStaging(): bool
    {
        return config('bancard.staging');
    }

    public static function baseUrl(): string
    {
        return self::isStaging() ? self::$staging : self::$production;
    }

    public static function publicKey(): string
    {
        return config('bancard.public');
    }

    public static function privateKey(): string
    {
        return config('bancard.private');
    }

    public static function scriptUrl(): string
    {
        $baseUrl = self::baseUrl();
        $script = self::$script;

        return "{$baseUrl}/{$script}";
    }

    /**
     * Start the payment process.
     *
     * @param string $description Description of the payment.
     * @param float $amount Amount in Guaraníes.
     * @return Response
     */
    public static function singleBuy(string $description, float $amount): Response
    {
        $operation = new SingleBuy($description, $amount);
        return $operation->makeRequest();
    }

    /**
     * Start de registration process of a card.
     *
     * @param integer $userId
     * @param string $userCellPhone
     * @param string $userMail
     * @return Response
     */
    public static function newCard(int $userId, string $userCellPhone, string $userMail): Response
    {
        $operation = new NewCard($userId, $userCellPhone, $userMail);
        return $operation->makeRequest();
    }

    /**
     * Operation that allows to list the cards registered by a user.
     *
     * @param integer $userId
     * @return Response
     */
    public static function listCards(int $userId): Response
    {
        $operation = new ListCards($userId);
        return $operation->makeRequest();
    }

    /**
     * Operation that allows you to delete a registered card.
     *
     * @param integer $userId
     * @param string $aliasToken
     * @return Response
     */
    public static function deleteCard(int $userId, string $aliasToken): Response
    {
        $operation = new DeleteCard($userId, $aliasToken);
        return $operation->makeRequest();
    }

    /**
     * Operation that allows payment with a token.
     *
     * @param string $description
     * @param float $amount
     * @param string $aliasToken
     * @return Response
     */
    public static function tokenCharge(string $description, float $amount, string $aliasToken): Response
    {
        $operation = new TokenCharge($description, $amount, $aliasToken);
        return $operation->makeRequest();
    }

    /**
     * Operation that allow to know if a payment (occasional or with token) was confirmed or not.
     *
     * @param string $shopProcessId
     * @return Response
     */
    public static function confirmation(string $shopProcessId): Response
    {
        $operation = new Confirmation($shopProcessId);
        return $operation->makeRequest();
    }

    /**
     * Operation that allows you to cancel the payment (occasional or with token).
     *
     * @param string $shopProcessId
     * @return Response
     */
    public static function rollback(string $shopProcessId): Response
    {
        $operation = new Rollback($shopProcessId);
        return $operation->makeRequest();
    }
}