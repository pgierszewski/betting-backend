<?php

namespace Spacestack\Rockly\Domain\Repository;

use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Match;
use Spacestack\Rockly\Domain\Bet;
use Spacestack\Rockly\Domain\Bet\BetItem;

interface BetRepository
{
    public function save(Bet $bet): Bet;
    public function saveBetItem(BetItem $bet): BetItem;
    public function getBetsByUser(User $user);
    public function getBetsByMatch(Match $match);
}
