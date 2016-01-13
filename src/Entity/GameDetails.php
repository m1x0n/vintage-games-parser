<?php

namespace VintageGamesParser\Entity;

use VintageGamesParser\Serializer\ArraySerializer;

class GameDetails
{
    use ArraySerializer;

    public $name;
    public $year;
    public $coinOp;
    public $marquee;
    public $screenShots = [];
    public $cabinets = [];

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->year = $data['year'];
        $this->coinOp = $data['coinOp'];
        $this->marquee = $data['marquee'];
        $this->screenShots = $data['screenShots'];
        $this->cabinets = $data['cabinets'];
    }
}