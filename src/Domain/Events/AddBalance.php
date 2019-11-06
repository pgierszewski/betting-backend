<?php

namespace Spacestack\Rockly\Domain\Events;

use Spacestack\Rockly\Domain\Event;

class AddBalance extends Event
{
    /**
     * @var int
     */
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
