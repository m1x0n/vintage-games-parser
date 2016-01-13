<?php

namespace VintageGamesParser\Aggregator;

use VintageGamesParser\Entity\Game;
use VintageGamesParser\Parser\GamesDetailsParser;
use VintageGamesParser\Parser\GamesParser;

class GamesAggregator implements AggregatorInterface
{
    private $gamesParser;
    private $gamesDetailsParser;

    public function __construct(GamesParser $games, GamesDetailsParser $details)
    {
        $this->gamesParser = $games;
        $this->gamesDetailsParser = $details;
    }

    /**
     * @param $url
     * @return array
     */
    public function aggregate($url)
    {
        $games = $this->gamesParser->parse($url);
        return $this->retrieveGamesData($games);
    }


    /**
     * @param Game[] $games
     * @return array
     */
    private function retrieveGamesData($games)
    {
        $data = [];

        foreach($games as $game) {
            $details = $this->gamesDetailsParser->parse($game->url);
            $data[] = $details->toArray();
        }

        return $data;
    }
}