<?php

namespace Spacestack\Rockly\Domain\Events;

use Spacestack\Rockly\Domain\Event;

class BetPlaced extends Event
{
    private $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
