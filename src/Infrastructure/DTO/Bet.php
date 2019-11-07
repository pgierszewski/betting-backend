<?php

namespace Spacestack\Rockly\Infrastructure\DTO;

use Spacestack\Rockly\Infrastructure\DTO\BetItem;

class Bet implements DTO
{
    /**
     * @var BetItem[]
     */
    public $betItems;
    /** @var int */
    public $amount;
}
