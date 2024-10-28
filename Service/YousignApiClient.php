<?php

namespace Neyric\YousignBundle\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class YousignApiClient
{
    private string $baseUrl;

    private HttpClientInterface $httpClient;

    /**
     * YousignApiClient constructor.
     */
    public function __construct(string $baseUrl, string $apiSecret)
    {
        $this->baseUrl = $baseUrl;

        $this->httpClient = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer '.$apiSecret,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    private function getRequest(string $url, array $queryParameters = []): ResponseInterface
    {
        return $this->httpClient->request('GET', $url, [
            'query' => $queryParameters,
        ]);
    }

    private function postRequest($url, $args = []): ResponseInterface
    {
        return $this->httpClient->request('POST', $url, [
            'json' => $args,
        ]);
    }

    public function getUsers(): array
    {
        return $this->getRequest($this->baseUrl.'/users')->toArray();
    }

    /**
     * @param string $filename
     * @param string $content
     * @return array
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function createNewFile(string $filename, string $content): array
    {
        $args = [
            'name' => $filename,
            'content' => $content,
        ];

        return $this->postRequest($this->baseUrl.'/files', $args)->toArray();
    }

    /**
     * @param $procedure
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function createProcedure($procedure): array
    {
        return $this->postRequest($this->baseUrl.'/procedures', $procedure)->toArray();
    }

    /**
     * @param string $fileId
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getFile(string $fileId): array
    {
        return $this->getRequest($this->baseUrl.'/files/'.$fileId)->toArray();
    }

    /**
     * @param string $fileId
     * @param bool $binary
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function downloadFile(string $fileId, bool $binary = false): string
    {
        return $this->getRequest($this->baseUrl.'/files/'.$fileId.'/download'.($binary ? '?alt=media' : ''))->getContent();
    }

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getProcedures(): array
    {
        return $this->getRequest($this->baseUrl.'/procedures')->toArray();
    }

    /**
     * @param $procedureId
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getProcedure($procedureId): array
    {
        return $this->getRequest($this->baseUrl.'/procedures/'.$procedureId)->toArray();
    }
}
