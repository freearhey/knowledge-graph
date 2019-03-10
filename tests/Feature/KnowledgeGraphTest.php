<?php

namespace KnowledgeGraph\Tests;

use KnowledgeGraph\Client;
use KnowledgeGraph\KnowledgeGraph;
use PHPUnit\Framework\TestCase;

class KnowledgeGraphTest extends TestCase 
{
  private $client;

  public function setUp()
  {
    parent::setUp();

    $client = new Client();

    $client->setKey(getenv('API_KEY'));

    $this->graph = new KnowledgeGraph($client);
  }
  
  public function testSearchByName() 
  {
    $results = $this->graph->search('taylor swift');

    $singleResult = $results->first();

    $this->assertEquals('/m/0dl567', $singleResult->id);

    $this->assertEquals(['Thing', 'Person'], $singleResult->type);
  }

  public function testSetSearchType()
  {
    $results = $this->graph->search('taylor', 'Book');

    $singleResult = $results->first();

    $this->assertContains('Book', $singleResult->type);
  }

  public function testSetSearchLanguage()
  {
    $results = $this->graph->search('taylor swift', null, 'fr');

    $singleResult = $results->first();

    $this->assertEquals('Auteure-compositrice-interprète', $singleResult->description);
  }

  public function testSetSearchLimit()
  {
    $results = $this->graph->search('taylor', null, null, 1);

    $this->assertEquals(1, $results->count());
  }

  public function testSearchWithoutResults() 
  {
    $results = $this->graph->search('asdfgh');

    $this->assertEquals(true, $results->isEmpty());
  }

  public function testFindBySingleId() 
  {
    $result = $this->graph->find('/m/0dl567');

    $this->assertEquals('Taylor Swift', $result->name);
  }

  public function testSetFindLanguage() 
  {
    $result = $this->graph->find('/m/0dl567', 'ru');

    $this->assertEquals('Тейлор Свифт', $result->name);
  }

  public function testFindWithoutResults() 
  {
    $result = $this->graph->find('asdfgh');

    $this->assertEquals(null, $result);
  }
}