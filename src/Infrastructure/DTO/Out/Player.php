<?php

namespace Spacestack\Rockly\Infrastructure\DTO\Out;

use Spacestack\Rockly\Infrastructure\DTO\DTO;

class Player implements DTO
{
    /** @var int */
    public $position;
    /** @var string */
    public $email;
    /** @var int */
    public $balance;
}
