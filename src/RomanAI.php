<?php

declare(strict_types=1);

namespace RomanAI;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class EnaLogEventException extends Exception
{
}

final class Client
{
    private $httpClient;

    public function __construct(string $apiKey, $client = null)
    {
        $this->httpClient = $client ?? new HttpClient([
            'base_uri' => 'https://api.romanai.dev/v1/',
            'headers' => ['Authorization' => 'Bearer: ' . $apiKey],
        ]);
    }

    public function pushEvent(array $event)
    {
        try {
            $res = $this->httpClient->post('requests', [
                'json' => $event,
            ]);

            $body = $res->getBody();

            return $body->getContents();
        } catch (ClientException $e) {
            return;
        } catch (ServerException $e) {
            return;
        }
    }
}
