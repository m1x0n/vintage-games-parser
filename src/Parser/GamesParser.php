<?php

namespace VintageGamesParser\Parser;

use Symfony\Component\DomCrawler\Crawler;

class GamesParser implements ParserInterface
{
    public $domCrawler;

    public function __construct(Crawler $crawler)
    {
        $this->domCrawler = $crawler;
    }

    public function parse($url)
    {
        return $url;
    }
}