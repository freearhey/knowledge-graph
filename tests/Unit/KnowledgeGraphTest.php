<?php

namespace KnowledgeGraph\Tests;

use KnowledgeGraph\Client;
use KnowledgeGraph\KnowledgeGraph;
use PHPUnit\Framework\TestCase;

class KnowledgeGraphTest extends TestCase 
{
  private $client;

  private $graph;

  public function setUp(): void
  {

    $client = new Client();

    $client->setKey(getenv('API_KEY'));

    $this->graph = new KnowledgeGraph($client);
  }
  
  public function testSearchByName() 
  {
    $results = $this->graph->search('taylor swift');

    $singleResult = $results->first();

    $this->assertEquals('/m/0dl567', $singleResult->id);
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

    $this->assertEquals('Compositrice-interprète', $singleResult->description);
  }

  public function testSetSearchWithMultipleLanguages()
  {
    $results = $this->graph->search('taylor swift', null, 'fr,de');

    $singleResult = $results->first();

    $de = array_search('de', array_column($singleResult->description, '@language'));
    
    $fr = array_search('fr', array_column($singleResult->description, '@language'));

    $this->assertEquals('Sängerin', $singleResult->description[$de]['@value']);

    $this->assertEquals('Compositrice-interprète', $singleResult->description[$fr]['@value']);
  }

  public function testSetSearchLimit()
  {
    $results = $this->graph->search('taylor', null, null, 1);

    $this->assertEquals(1, $results->count());
  }

  public function testSearchWithoutResults() 
  {
    $results = $this->graph->search('asdfgh123');

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

  public function testSetFindWithMultipleLanguages() 
  {
    $result = $this->graph->find('/m/0dl567', 'de,fr');

    $de = array_search('de', array_column($result->description, '@language'));
    
    $fr = array_search('fr', array_column($result->description, '@language'));

    $this->assertEquals('Sängerin', $result->description[$de]['@value']);

    $this->assertEquals('Compositrice-interprète', $result->description[$fr]['@value']);
  }

  public function testFindWithoutResults() 
  {
    $result = $this->graph->find('asdfgh123');

    $this->assertEquals(null, $result);
  }
}