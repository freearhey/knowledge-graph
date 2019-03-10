<?php

namespace KnowledgeGraph;

class KnowledgeGraph
{
  /**
   * @var \KnowledgeGraph\Client
   */
  private $client;

  /**
   * @param \KnowledgeGraph\Client $client
   */
  public function __construct($client)
  {
    $this->client = $client;
  }

  /**
   * Search by entity name
   * 
   * @param string $query
   * @param string $type Restricts returned results to those of the specified types. (e.g. "Person")
   * @param string $lang Language code (ISO 639) to run the query with (e.g. "es")
   * @param string $limit Limits the number of results to be returned. (default: 20)
   *
   * @return \Illuminate\Support\Collection Return collection of \KnowledgeGraph\SearchResult
   */
  public function search($query, $type = null, $lang = null, $limit = null)
  {
    $results = $this->client->request([
      'query' => $query,
      'types' => $type,
      'languages' => $lang,
      'limit' => $limit
    ]);

    return $results;
  }

  /**
   * Find entity by ID
   * 
   * @param string $id (e.g. /m/0dl567)
   * @param string $lang Language code (ISO 639) to run the query with (e.g. "es")
   *
   * @return \KnowledgeGraph\SearchResult|null Return \KnowledgeGraph\Result or null if results not found
   */
  public function find($id, $lang = null)
  {
    $results = $this->client->request([
      'ids' => $id,
      'languages' => $lang
    ]);

    if($results->isEmpty()) {
      return null;
    }

    return $results->first();
  }
}