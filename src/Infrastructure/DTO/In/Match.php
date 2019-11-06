<?php

namespace Spacestack\Rockly\Infrastructure\DTO\In;

use Spacestack\Rockly\Infrastructure\DTO\DTO;

class Match implements DTO
{
    /** @var int */
    public $teamAId;
    /** @var int */
    public $teamBId;
    /** @var float */
    public $oddsA;
    /** @var float */
    public $oddsB;
}
