<?php

namespace VintageGamesParser\Serializer;

trait ArraySerializer
{
    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}