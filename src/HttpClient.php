<?php
/**
 * Created by graphql-client.
 * User: Ruslan Evchev
 * Date: 26.11.16
 * Email: aion.planet.com@gmail.com
 */

namespace GraphQLClient;

use GraphQLClient\Util\DatableHttpException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Stream;
use QueryBuilder\Interfaces\BuilderInterface;

class HttpClient
{

    protected $apiUrl;

    protected $apiKey;

    /** @var  Client */
    protected $client;

    protected $requestId;

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param mixed $apiKey
     *
     * @return HttpClient
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client();

        return $this;
    }

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function call(BuilderInterface $builder)
    {
        $this->requestId = uniqid();

        $stream = $this->client->request('POST', $this->apiUrl, [
            'json'    => [
                'query' => $builder->build(),
            ],
            'headers' => [
                'content-type' => 'application/json',
                'Authorization' => 'Bearer '.$this->apiKey,
                'decode_content' => false,
                'request-id'   => $this->requestId,
            ],
        ])->getBody();

        return $this->processResponse($stream);
    }

    private function processResponse(Stream $stream)
    {
        $data = json_decode($stream->getContents(), true);

        if (isset($data['errors'])) {
            throw new DatableHttpException(json_encode([
                'error_stack' => $this->processErrors($data['errors']),
                'requestId'   => $this->requestId,
            ]));
        }

        return $data['data'];
    }

    private function processErrors(array $errors)
    {
        $messages = [];

        foreach ($errors as $error) {
            $messages[] = $error['message'];
        }

        return $messages;
    }

}