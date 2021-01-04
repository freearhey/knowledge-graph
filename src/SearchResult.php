<?php

namespace KnowledgeGraph;

class SearchResult
{
  /**
   * Result unique id
   * @var string
   */
  public $id;

  /**
   * Result score
   * @var float
   */
  public $score;

  /**
   * Result name
   * @var string
   */
  public $name;

  /**
   * List of result types
   * @var string[]
   */
  public $type;

  /**
   * Result short description
   * @var string
   */
  public $description;

  /**
   * Image of result item
   * @var string[]
   */
  public $image;

  /**
   * Detailed description of the item
   * @var string[]
   */
  public $detailedDescription;

  /**
   * Result website url
   * @var string
   */
  public $url;

  /**
   * @param array $data
   */
  public function __construct($data)
  {
    $this->parseData($data);
  }

  /**
   * Parse input data
   *
   * @param array $data
   */
  private function parseData($data)
  {
    $this->id = isset($data['result']['@id']) ? $this->parseId($data['result']['@id']) : null;
    $this->score = $data['resultScore'];
    $this->name = isset($data['result']['name']) ? $data['result']['name'] : null;
    $this->type = isset($data['result']['@type']) ? $data['result']['@type'] : [];
    $this->description = isset($data['result']['description']) ? $data['result']['description'] : null;
    $this->image = isset($data['result']['image']) ? $data['result']['image'] : [];
    $this->detailedDescription = isset($data['result']['detailedDescription']) ? $data['result']['detailedDescription'] : [];
    $this->url = isset($data['result']['url']) ? $data['result']['url'] : null;
  }

  /**
   * Parse ID of result
   *
   * @param string $string Knowledge Graph raw ID (e.g. kg:/m/0dl567)
   *
   * @return string Result ID
   */
  private function parseId($string)
  {
    preg_match('/kg:(.*)/', $string, $matches);
    return $matches[1];
  }
}
