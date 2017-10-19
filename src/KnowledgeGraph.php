<?php

namespace KnowledgeGraph;

class KnowledgeGraph
{
  /**
   * @var \KnowledgeGraph\Client
   */
  private $client;

  /**
   * @var array
   */
  private $options;

  /**
   * @param \KnowledgeGraph\Client $client
   * @param array $options
   */
  public function __construct($client, $options = [])
  {
    $this->client = $client;

    $this->options = $options;
  }

  /**
   * Search by name
   * 
   * @param string $query
   *
   * @return \Illuminate\Support\Collection Return collection of \KnowledgeGraph\Result
   */
  public function search($query)
  {
    $results = $this->client->request([
      'query' => $query
    ], $this->options);

    return $results;
  }

  /**
   * Find by ID
   * 
   * @param string $id (e.g. /m/0dl567)
   *
   * @return \Illuminate\Support\Collection Return collection of \KnowledgeGraph\Result
   */
  public function find($id)
  {
    $results = $this->client->request([
      'ids' => $id
    ], $this->options);

    return $results;
  }
}