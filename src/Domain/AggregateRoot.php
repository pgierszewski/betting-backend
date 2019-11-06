<?php

namespace Spacestack\Rockly\Domain;

abstract class AggregateRoot
{
    private $events = [];

    public function dispatchEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}