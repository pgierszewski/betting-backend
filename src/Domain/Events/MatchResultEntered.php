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
    /** @var Team */
    private $winner;

    public function __construct(int $matchId, int $pointA, int $pointB, Team $winner)
    {
        $this->matchId = $matchId;
        $this->pointA = $pointA;
        $this->pointB = $pointB;
        $this->winner = $winner;
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

    public function getWinner(): Team
    {
        return $this->winner;
    }
}
