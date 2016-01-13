<?php

namespace VintageGamesParser\Parser;

use Symfony\Component\DomCrawler\Crawler;
use VintageGamesParser\Entity\Game;
use VintageGamesParser\Loader\ContentLoaderInterface;

class GamesParser implements ParserInterface
{
    public $domCrawler;
    public $contentLoader;

    public function __construct(Crawler $crawler, ContentLoaderInterface $loader)
    {
        $this->domCrawler = $crawler;
        $this->contentLoader = $loader;
    }

    public function parse($url)
    {
        $html = $this->contentLoader->load($url);
        $this->domCrawler->add($html);

        $games = $this->domCrawler->filter('body > ol > li > a')->extract(array('_text', 'href'));

        return array_map(function($data) { return new Game($data); }, $games);
    }
}