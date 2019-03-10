<?php 

namespace KnowledgeGraph;

use KnowledgeGraph\SearchResult;
use GuzzleHttp\Exception\ClientException;

class Client
{
  const API_ENDPOINT = 'https://kgsearch.googleapis.com/v1/entities:search';

  /**
   * @var string Google API Key
   */
  private $key;

  /**
   * @var \GuzzleHttp\Client
   */
  private $client;

  public function __construct()
  {
    $this->client = new \GuzzleHttp\Client();
  }

  /**
   * Set API Key
   * 
   * @var string $key
   */
  public function setKey($key)
  {
    $this->key = $key;
  }

  /**
   * Make request to Knowledge Graph API
   * 
   * @var array $params
   *
   * @return \Illuminate\Support\Collection Return collection of \KnowledgeGraph\Result
   */
  public function request($params)
  {
    $query = array_merge($params, [
      'key' => $this->key
    ]);

    try {

      $response = $this->client->get(self::API_ENDPOINT, [
        'query' => $query
      ]);

    } catch (ClientException $exception) {

      return collect([]);

    }

    $results = json_decode($response->getBody(), true);

    $output = [];

    for($i = 0; $i < count($results['itemListElement']); $i++) {
      $output[] = new SearchResult($results['itemListElement'][$i]);
    }

    return collect($output);
  }
}