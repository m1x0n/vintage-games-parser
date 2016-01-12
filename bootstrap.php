<?php

use Pimple\Container;

require_once dirname(__FILE__) . '/vendor/autoload.php';

$bindings = [
    'application' => function($c) {
        return new \VintageGamesParser\Application($c['parser']);
    },

    'parser' => function($c) {
        return new VintageGamesParser\Parser\GamesParser($c['crawler']);
    },

    'crawler' => function($c) {
        return new \Symfony\Component\DomCrawler\Crawler();
    }
];

$container = new Container($bindings);
return $container;
