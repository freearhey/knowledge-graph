<?php

namespace KnowledgeGraph\Tests;

use KnowledgeGraph\Client;
use KnowledgeGraph\KnowledgeGraph;

class KnowledgeGraphTest extends \PHPUnit_Framework_TestCase 
{
  private $client;

  public function setUp()
  {
    parent::setUp();

    $client = new Client();

    $client->setKey('AIzaSyBynQI2mqlqT4qbpR3qYQjsGH7dRqFKaQc');

    $this->client = $client;
  }

  public function testSetResultsLimit()
  {
    $options = ['limit' => 1];

    $graph = new KnowledgeGraph($this->client, $options);

    $results = $graph->search('taylor');

    $this->assertEquals(1, $results->count());
  }

  public function testSetResultsType()
  {
    $options = ['types' => 'Book'];

    $graph = new KnowledgeGraph($this->client, $options);

    $results = $graph->search('taylor');

    $singleResult = $results->first();

    $this->assertContains('Book', $singleResult->type);
  }

  public function testSearchByTerm() 
  {
    $graph = new KnowledgeGraph($this->client);

    $results = $graph->search('taylor swift');

    $singleResult = $results->first();

    $this->assertEquals('/m/0dl567', $singleResult->id);

    $this->assertEquals(['Thing', 'Person'], $singleResult->type);
  }

  public function testFindBySingleId() 
  {
    $graph = new KnowledgeGraph($this->client);

    $results = $graph->find('/m/0dl567');

    $singleResult = $results->first();

    $resultName = $singleResult->name;

    $this->assertEquals('Taylor Swift', $resultName);
  }

  public function testNoResults() 
  {
    $graph = new KnowledgeGraph($this->client);

    $results = $graph->search('asdfgh');

    $this->assertEquals(true, $results->isEmpty());
  }
}