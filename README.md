Knowledge Graph
===============

A simple PHP client for working with [Google Knowledge Graph API](https://developers.google.com/knowledge-graph/).

### Installation
```sh
composer require freearhey/knowledge-graph
```

### Usage

```php
$client = new Client();

$client->setKey('YOUR_APP_KEY');

$graph = new KnowledgeGraph($client, $options);
```

#### Search

Search by name:
```php
$results = $graph->search('taylor swift');
```

Find by ID:
```php
$results = $graph->find('/m/0dl567');
```

Check if no search results
```php
if($results->isEmpty()) {
  echo 'no results';
  die();
}
```

#### Result

Retrieve first result
```php
$singleResult = $results->first();
```

Get result ID
```php
$resultId = $singleResult->id; // string(9) "/m/0dl567"
```

Get result name
```php
$resultLabel = $singleResult->name; // string(12) "Taylor Swift"
```

Get result type
```php
$resultType = $singleResult->type; // array(2) { [0]=> string(5) "Thing", ... }
```

Get result description
```php
$resultDescription = $singleResult->description; // string(26) "American singer-songwriter"
```

Get result image
```php
$resultImage = $singleResult->image;

/**
* array(2) {
*  ["contentUrl"]=> string(91) "http://t0.gstatic.com/images?q=tbn:ANd9GcST848UJ0u31E6aoQfb2nnKZFyad7rwNF0ZLOCACGpu4jnboEzV"
*  ["url"]=> string(61) "https://en.wikipedia.org/wiki/Begin_Again_(Taylor_Swift_song)"
* }
*/
```

Get result detailed description
```php
$resultDetailedDescription = $singleResult->detailedDescription;

/**
* array(3) {
*  ["articleBody"]=> string(210) "Taylor Alison Swift is an American singer-songwriter. One of the leading contemporary recording artists, she is known for narrative songs about her personal life, which have received widespread media coverage."
*  ["url"]=> string(42) "https://en.wikipedia.org/wiki/Taylor_Swift"
*  ["license"]=> string(108) "https://en.wikipedia.org/wiki/Wikipedia:Text_of_Creative_Commons_Attribution-ShareAlike_3.0_Unported_License"
* }
*/
```

That's all.

### License
Knowledge Graph is licensed under the [MIT license](http://opensource.org/licenses/MIT).