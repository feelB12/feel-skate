<?php

namespace App\Serializer;

use App\Entity\Event;

interface SerializerInterface
{
    /**
     * @param Event[] $events
     *
     * @return string json
     */
    public function serialize(array $events): string;
}