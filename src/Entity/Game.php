<?php

namespace VintageGamesParser\Entity;

use VintageGamesParser\Serializer\ArraySerializer;

class Game
{
    use ArraySerializer;

    public $name;
    public $url;

    public function __construct($data)
    {
        $this->name = $data[0];
        $this->url = $data[1];
    }
}