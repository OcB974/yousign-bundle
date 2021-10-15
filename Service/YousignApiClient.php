<?php

namespace Neyric\YousignBundle\Service;

use Symfony\Component\HttpClient\HttpClient;

class YousignApiClient
{
    private $baseUrl;

    private $httpClient;

    /**
     * YousignApiClient constructor
     *
     * @param string $baseUrl
     * @param string $apiSecret
     */
    public function __construct($baseUrl, $apiSecret)
    {
        $this->baseUrl = $baseUrl;

        $this->httpClient = HttpClient::create([
            'headers' => [
                'Authorization' => 'Bearer ' . $apiSecret,
                'Content-Type' => 'application/json'
            ]
        ]);
    }


    private function getRequest($url, $queryParameters = [])
    {
        return $this->httpClient->request('GET', $url, [
            'query' => $queryParameters
        ]);
    }

    private function postRequest($url, $args = [])
    {
        return $this->httpClient->request('POST', $url, [
            'json' => $args
        ]);
    }

    public function getUsers()
    {
        return $this->getRequest($this->baseUrl . '/users')->toArray();
    }

    /**
     * @var string $filename
     * @var string $content (base64 without the base64 header)
     *
     * @return array
     */
    public function createNewFile($filename, $content)
    {
        $args = [
            'name' => $filename,
            'content' => $content
        ];

        return $this->postRequest($this->baseUrl . '/files', $args)->toArray();
    }
    

    /**
     * @param array $procedure
     *
     * @return array
     */
    public function createProcedure($procedure)
    {
        return $this->postRequest($this->baseUrl . '/procedures', $procedure)->toArray();
    }

    /**
     * @param string $fileId
     *
     * @return array
     */
    public function getFile($fileId)
    {
        return $this->getRequest($this->baseUrl . '/files/' . $fileId)->toArray();
    }

    /**
     * @param string $fileId
     *
     * @return string
     */
    public function downloadFile($fileId, $binary = false)
    {
        return $this->getRequest($this->baseUrl . '/files/' . $fileId .'/download' . ($binary ? "?alt=media" : "") )->getContent();
    }

    /**
     * @return string
     */
    public function getProcedures()
    {
        return $this->getRequest($this->baseUrl . '/procedures')->getContent();
    }
}
