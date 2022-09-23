<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Core;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Simple API handler.
 */
class ApiClient
{
    private string $_apiKey;

    private string $_clientSlug;

    private string $_apiBaseUrl;

    private GuzzleClient $client;

    public function __construct(string $apiKey, string $clientSlug, string $apiBaseUrl)
    {
        $this->_apiKey     = $apiKey;
        $this->_clientSlug = $clientSlug;
        $this->_apiBaseUrl = $apiBaseUrl;

        $this->client = new GuzzleClient([
            'base_uri'        => $this->_apiBaseUrl,
            'connect_timeout' => 5,
            'verify'          => false,
        ]);
    }

    /**
     * @return mixed|null
     *
     * @throws GuzzleException
     */
    public function getItemList(): mixed
    {
        $response = $this->sendRequest('GET', 'item?startDate=1651343906&endDate=1651797432');

        return $response['data'] ?? null;
    }

    /**
     * @return mixed|null
     * @throws Exception
     * @throws GuzzleException
     */
    public function getEmployeeList(): mixed
    {
        $response = $this->sendRequest('GET', 'employee/') ?? [];

        return $response['data'] ?? null;
    }

    /**
     * @param string $method
     * @param string $urlPath
     * @param        $data
     *
     * @return array
     * @throws GuzzleException
     */
    protected function sendRequest(string $method, string $urlPath, $data = []): array
    {
        try {
            $res     = $this->client->request($method, "/v1/$urlPath",
                [
                    'headers' => [
                        'X-API-CLIENT' => $this->_clientSlug,
                        'X-API-Key'    => $this->_apiKey,
                    ],
                    'json'    => $data
                ]);
            $content = $res->getBody()->getContents();

            return json_decode($content, true);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 0, $e);
        }
    }
}