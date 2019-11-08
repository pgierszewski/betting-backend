<?php

namespace Spacestack\Rockly\Infrastructure\DTO\Out;

use Spacestack\Rockly\Infrastructure\DTO\DTO;

class BetHistoryItem implements DTO
{
    /** @var string */
    public $teamA;
    /** @var string */
    public $teamB;
    /** @var bool */
    public $successful;
    /** @var float */
    public $odds;
    /** @var string */
    public $type;
}
