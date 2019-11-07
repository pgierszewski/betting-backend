<?php

namespace Spacestack\Rockly\Domain\Events;

use Spacestack\Rockly\Domain\Event;
use Spacestack\Rockly\Domain\Team;

class MatchResultEntered extends Event
{
    /** @var int */
    private $matchId;
    /** @var int */
    private $pointA;
    /** @var int */
    private $pointB;
    /** @var int */
    private $winnerId;

    public function __construct(int $matchId, int $pointA, int $pointB, int $winnerId)
    {
        $this->matchId = $matchId;
        $this->pointA = $pointA;
        $this->pointB = $pointB;
        $this->winnerId = $winnerId;
    }

    public function getPointB(): int
    {
        return $this->pointB;
    }

    public function getPointA(): int
    {
        return $this->pointA;
    }

    public function getMatchId(): int
    {
        return $this->matchId;
    }

    public function getWinnerId(): int
    {
        return $this->winnerId;
    }
}
