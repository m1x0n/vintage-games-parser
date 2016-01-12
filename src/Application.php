<?php

namespace VintageGamesParser;

use VintageGamesParser\Parser\ParserInterface;

class Application
{
    /**
     * @var ParserInterface
     */
    public $parser;

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function run($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            echo sprintf("Invalid url %s provided\n", $url);
        } else {
            $data = $this->parser->parse($url);
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }
}