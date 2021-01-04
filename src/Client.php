<?php

namespace KnowledgeGraph;

use GuzzleHttp\Exception\ClientException;
use KnowledgeGraph\SearchResult;

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
    $params['languages'] = explode(',', $params['languages']);

    $query = array_merge($params, [
      'key' => $this->key,
    ]);

    try {

      $response = $this->client->get(self::API_ENDPOINT, [
        'query' => custom_build_query($query),
      ]);

    } catch (ClientException $exception) {

      return collect([]);

    }

    $results = json_decode($response->getBody(), true);

    $output = [];

    for ($i = 0; $i < count($results['itemListElement']); $i++) {
      $output[] = new SearchResult($results['itemListElement'][$i]);
    }

    return collect($output);
  }
}

function custom_build_query($data)
{
  $query = array();
  foreach ($data as $name => $value) {
    $value = (array) $value;
    array_walk_recursive($value, function ($value) use (&$query, $name) {
      if (!empty($value)) {
        $query[] = urlencode($name) . '=' . urlencode($value);
      }
    });
  }

  return implode("&", $query);
}
