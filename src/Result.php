<?php

namespace KnowledgeGraph;

class Result
{
  /**
   * Result score
   * @var float
   */
  public $score;

  /**
   * Result unique id
   * @var string
   */
  public $id;

  /**
   * List of result types
   * @var string[]
   */
  public $type;

  /**
   * Result data
   * @var array
   */
  private $data;

  /**
   * @param array $data
   */
  public function __construct($data)
  {
    $this->score = $data['resultScore'];
    $this->data = $data['result'];
    $this->id = $this->getId($data['result']['@id']);
    $this->type = $data['result']['@type'];
  }

  /**
   * Get value of specific property
   * 
   * @param string $name Name of property
   *
   * @return  mix Value of property
   */
  public function __get($name)
  {
    return array_key_exists($name, $this->data) ? $this->data[$name] : null;
  }

  /**
   * Parse ID of result
   * 
   * @param string $string Knowledge Graph raw ID (e.g. kg:/m/0dl567)
   *
   * @return string Result ID
   */
  private function getId($string)
  {
    preg_match('/kg:(.*)/', $string, $matches);

    return $matches[1];
  }
}