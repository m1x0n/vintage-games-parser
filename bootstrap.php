<?php

use Pimple\Container;

require_once dirname(__FILE__) . '/vendor/autoload.php';

$container = new Container();

$container['application'] = function($c) {
    return new \VintageGamesParser\Application($c['aggregator']);
};

$container['games_parser'] = function($c) {
    return new VintageGamesParser\Parser\GamesParser($c['crawler'], $c['loader']);
};

$container['games_details_parser'] = function($c) {
    return new \VintageGamesParser\Parser\GamesDetailsParser($c['crawler'], $c['loader']);
};

$container['crawler'] = $container->factory(function($c) {
    return new \Symfony\Component\DomCrawler\Crawler();
});

$container['loader'] = function ($c) {
    return new \VintageGamesParser\Loader\WebPageLoader();
};

$container['aggregator'] = function($c) {
    return new \VintageGamesParser\Aggregator\GamesAggregator($c['games_parser'], $c['games_details_parser']);
};

return $container;
