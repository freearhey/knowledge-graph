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
    $data = $this->formatData($data);

    $this->id = $this->parseId($data['id']);
    $this->name = $data['name'];
    $this->type = $data['type'];
    $this->description = $data['description'];
    $this->image = $data['image'];
    $this->detailedDescription = $data['detailedDescription'];
    $this->url = $data['url'];
  }

  private function formatData($data)
  {
    $id = isset($data['result']['@id']) ? $data['result']['@id'] : null;
    $name = isset($data['result']['name']) ? $data['result']['name'] : null;
    $type = isset($data['result']['@type']) ? $data['result']['@type'] : [];
    $description = isset($data['result']['description']) ? $data['result']['description'] : null;
    $image = isset($data['result']['image']) ? $data['result']['image'] : [];
    $detailedDescription = isset($data['result']['detailedDescription']) ? $data['result']['detailedDescription'] : [];
    $url = isset($data['result']['url']) ? $data['result']['url'] : null;

    return [
      'id' => $id,
      'name' => $name,
      'type' => $type,
      'description' => $description,
      'image' => $image,
      'detailedDescription' => $detailedDescription,
      'url' => $url
    ];
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