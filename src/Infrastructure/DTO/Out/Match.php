<?php

namespace Spacestack\Rockly\Infrastructure\DTO\Out;

use Spacestack\Rockly\Infrastructure\DTO\DTO;

class Match implements DTO
{
    /** @var string */
    public $teamNameA;
    /** @var int */
    public $teamIdA;
    /** @var string */
    public $teamNameB;
    /** @var int */
    public $teamIdB;
    /** @var float */
    public $oddsA;
    /** @var float */
    public $oddsB;
    /** @var int|null */
    public $pointA;
    /** @var int|null */
    public $pointB;
    /** @var int|null */
    public $winner;
}
