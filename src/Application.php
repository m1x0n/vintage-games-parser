<?php

namespace VintageGamesParser;

use VintageGamesParser\Aggregator\AggregatorInterface;

class Application
{
    const ENDPOINT = "http://www.arcade-museum.com/TOP100.php";

    /**
     * @var AggregatorInterface
     */
    private $aggregator;

    public function __construct(AggregatorInterface $aggregator)
    {
        $this->aggregator = $aggregator;
    }

    public function run()
    {
        $data = $this->aggregator->aggregate(self::ENDPOINT);
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}