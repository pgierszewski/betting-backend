<?php

namespace Spacestack\Rockly\Infrastructure\DTO\Out;

use Spacestack\Rockly\Infrastructure\DTO\DTO;

class BetHistory implements DTO
{
    /** @var int */
    public $winnings;
    /** @var bool */
    public $successful;
    /** @var string */
    public $occuredOn;
    /** @var string */
    public $resolvedOn;
    /** @var BetHistoryItem[] */
    public $items;
}
