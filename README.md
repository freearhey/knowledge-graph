Knowledge Graph [![Build Status](https://travis-ci.org/freearhey/knowledge-graph.svg?branch=master)](https://travis-ci.org/freearhey/knowledge-graph)
===============

A simple PHP client for working with [Google Knowledge Graph API](https://developers.google.com/knowledge-graph/).

## Installation

```sh
composer require freearhey/knowledge-graph
```

## Usage

```php
require_once('vendor/autoload.php');

use KnowledgeGraph\Client;
use KnowledgeGraph\KnowledgeGraph;

$client = new Client();

$client->setKey('YOUR_API_KEY'); // More about API Key here: https://developers.google.com/knowledge-graph/how-tos/authorizing

$graph = new KnowledgeGraph($client);
```

### Available Methods

#### `search()`

The `search` method give you a way to search in Knowledge Graph by entity name.

```php
$results = $graph->search($query, $type, $lang, $limit);
```

Arguments:

- `$query`: term to search (required)
- `$type`: specify the type of results (e.g. "Book") (List of available types: https://developers.google.com/knowledge-graph/)
- `$lang`: specify the results language
- `$limit`: set a custom limit (default: 20)

Example:

```php
$results = $graph->search('taylor swift');

/*
  Collection {
    #items: array:20 [
      0 => SearchResult {
        id: "/m/0dl567"
        name: "Taylor Swift"
        type: array:2 [
          0 => "Thing"
          1 => "Person"
        ]
        description: "American singer"
        image: array:2 [
          "contentUrl" => "http://t0.gstatic.com/images?q=tbn:ANd9GcST848UJ0u31E6aoQfb2nnKZFyad7rwNF0ZLOCACGpu4jnboEzV"
          "url" => "https://en.wikipedia.org/wiki/Begin_Again_(Taylor_Swift_song)"
        ]
        detailedDescription: array:3 [
          "articleBody" => "Taylor Alison Swift is an American singer-songwriter. As one of the world's leading contemporary recording artists, she is known for narrative songs about her p ▶"
          "url" => "https://en.wikipedia.org/wiki/Taylor_Swift"
          "license" => "https://en.wikipedia.org/wiki/Wikipedia:Text_of_Creative_Commons_Attribution-ShareAlike_3.0_Unported_License"
        ]
        url: "http://taylorswift.com/"
      }
      ...
    ]
  }
 */
```

The `search` method always returns `Illuminate\Support\Collection` class with results. This means you can use all the [methods available](https://laravel.com/docs/5.6/collections#available-methods) in Laravel's Collections.

#### `find()`

The `find` method give you a way to search by entity ID.

```php
$results = $graph->find($id, $lang);
```

Arguments:

- `$id`: ID to search (e.g. "/m/0dl567")
- `$lang`: specify the results language

Example:

```php
$results = $graph->find('/m/02j81');

/*
  SearchResult { 
    id: "/m/02j81"
    name: "Eiffel Tower"
    type: array:5 [
      0 => "Thing"
      1 => "CivicStructure"
      2 => "Place"
      3 => "TouristAttraction"
      4 => "Organization"
    ]
    description: "Tower in Paris, France"
    image: array:2 [
      "contentUrl" => "http://t1.gstatic.com/images?q=tbn:ANd9GcSao5YmaJqJVcSi60m9ypkaIC6bjKVJdoocuGBzgyTIu4MaMJ-t"
      "url" => "https://commons.wikimedia.org/wiki/File:Eiffel_tower.svg"
    ]
    detailedDescription: array:3 [
      "articleBody" => "The Eiffel Tower is a wrought-iron lattice tower on the Champ de Mars in Paris, France. It is named after the engineer Gustave Eiffel, whose company designed an ▶"
      "url" => "https://en.wikipedia.org/wiki/Eiffel_Tower"
      "license" => "https://en.wikipedia.org/wiki/Wikipedia:Text_of_Creative_Commons_Attribution-ShareAlike_3.0_Unported_License"
    ]
    url: "http://www.eiffel-tower.com/"
  }
 */
```

### Testing

```sh
API_KEY=YOUR_API_KEY vendor/bin/phpunit
```

### Contribution

If you find a bug or want to contribute to the code or documentation, you can help by submitting an [issue](https://github.com/freearhey/knowledge-graph/issues) or a [pull request](https://github.com/freearhey/knowledge-graph/pulls).

### License
Knowledge Graph is licensed under the [MIT license](http://opensource.org/licenses/MIT).