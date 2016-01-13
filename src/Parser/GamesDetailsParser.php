<?php

namespace VintageGamesParser\Parser;

use Symfony\Component\DomCrawler\Crawler;
use VintageGamesParser\Entity\GameDetails;
use VintageGamesParser\Loader\ContentLoaderInterface;

class GamesDetailsParser implements ParserInterface
{
    const IMAGE_BASE_URL = 'http://www.arcade-museum.com';

    public $domCrawler;
    public $contentLoader;

    public function __construct(Crawler $crawler, ContentLoaderInterface $loader)
    {
        $this->domCrawler = $crawler;
        $this->contentLoader = $loader;
    }

    public function parse($url)
    {
        $baseImageUrl = self::IMAGE_BASE_URL;

        $html = $this->contentLoader->load($url);
        $this->domCrawler->add($html);

        $details = [];

        try {
            $textData = $this->domCrawler
                ->filter('table[width="80%"] td')
                ->eq(0)
                ->html();

            $extracted = $this->extractGameDetails($textData);
            $details['name'] = $extracted['name'];
            $details['year'] = (int)$extracted['year'];

            $coinOpImage = $this->domCrawler
                ->filter('img[alt="' . $details['name'] . '"]')
                ->extract(array('src'));

            $coinOpImage = array_map(function($img) use ($baseImageUrl) { return $baseImageUrl . $img;}, $coinOpImage);

            $details['coinOp'] = !empty($coinOpImage[0]) ? $coinOpImage[0] : null;

            $marqueeImage = $coinOpImage = $this->domCrawler
                ->filter('img[alt~="' . $details['name'] . ' - marquee"]')
                ->extract(array('src'));

            $marqueeImage = array_map(function($img) use ($baseImageUrl) { return $baseImageUrl . $img;}, $marqueeImage);

            $details['marquee'] = !empty($marqueeImage[0]) ? $marqueeImage[0] : null;

            $screenShots = $this->domCrawler
                ->filter('img[alt~="' . $details['name'] . ' - Title screen image"]')
                ->extract(array('src'));

            $screenShots = array_map(function($img) use ($baseImageUrl) { return $baseImageUrl . $img;}, $screenShots);

            $details['screenShots'] = $screenShots;

            $cabinets = $this->domCrawler
                ->filter('img[alt~="' . $details['name'] . ' - Cabinet Image"]')
                ->extract(array('src'));

            $cabinets = array_map(function($img) use ($baseImageUrl) { return $baseImageUrl . $img;}, $cabinets);

            $details['cabinets'] = $cabinets;

            $this->domCrawler->clear();

        } catch (\Exception $e) {
            $details = [
                'name' => null,
                'year' => null,
                'coinOp' => null,
                'marquee' => null,
                'screenShots' => [],
                'cabinets' => []
            ];
        }

        return new GameDetails($details);
    }

    /**
     * @param string $text
     * @return array
     */
    private function extractGameDetails($text)
    {
        $data = array_map('strip_tags', explode('<br>', str_replace("\n", '', $text)));
        $data = array_slice($data, 0, 10);
        $data = array_map(function($a) { return preg_replace('/:\s/', '=', $a, 1); }, $data);
        $str = implode('&', $data);
        parse_str($str, $data);

        $keys = array_map('strtolower', array_keys($data));
        $values = array_values($data);

        return array_combine($keys, $values);
    }
}