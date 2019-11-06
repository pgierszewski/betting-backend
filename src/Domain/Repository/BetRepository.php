<?php

namespace Spacestack\Rockly\Domain\Repository;

use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Match;

interface BetRepository
{
    public function getBetsByUser(User $user);

    public function getBetsByMatch(Match $match);
}
