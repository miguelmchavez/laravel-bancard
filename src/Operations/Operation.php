<?php 

namespace Deviam\Bancard\Operations;

use Deviam\Bancard\Bancard;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Deviam\Bancard\Petitions\Petition;

abstract class Operation
{
    abstract protected static function getResource(): string;

    abstract protected function getPetition(): Petition;

    abstract protected function handleSuccess(Petition $petition, Response $response): void;

    protected function getMethod(): string
    {
        return 'post';
    }

    public function makeRequest(): Response
    {
        $petition = $this->getPetition();
        $data = $petition->getOperationPetition();

        $method = $this->getMethod();
        $endpoint = self::getEndpoint();

        try {
            $response = Http::$method($endpoint, $data)->throw();
            $this->handleSuccess($petition, $response);
        } catch (RequestException $exception) {
            $response = $exception->response;
            // $this->handleError($response);
        }

        return $response;
    }

    protected static function getEndpoint(): string
    {
        $baseUrl = Bancard::baseUrl();
        $resource = static::getResource();

        return "{$baseUrl}/{$resource}";
    }
}