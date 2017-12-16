# trending-guthub

This package is a PHP port of [this module](https://github.com/ecrmnn/trending-github)

## Installation

``` bash
composer require fortecdev/trending-github
```

## Usage

```php
require_once __DIR__ . '/vendor/autoload.php';

use Fortec\GithubTrending;

$github = new GithubTrending();

$data = $github->getTrending();

var_dump($data);
/*
[
    [
        'author' => 'facebook',
        'name' => 'react',
        'url' => 'https://github.com/facebook/react',
        'description' => 'A declarative, efficient, and flexible JavaScript library for building user interfaces.',
        'language' => 'JavaScript',
        'stars' => '83,511',
        'forks' => '15,791',
        'starsToday' => '25 stars today'
    ],
    ...
]
*/
```

## License

The MIT License (MIT)

Copyright (c) 2017 Olumide Falomo