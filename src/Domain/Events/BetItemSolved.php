<?php

namespace Spacestack\Rockly\Domain\Events;

use Spacestack\Rockly\Domain\Event;

class BetItemSolved extends Event
{
    /**
     * @var int
     */
    private $betId;

    public function __construct(int $betId)
    {
        $this->betId = $betId;
    }

    public function getBetId(): int
    {
        return $this->betId;
    }
}
