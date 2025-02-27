<?php

namespace Spacestack\Rockly\Domain\Repository;

use Spacestack\Rockly\Domain\Match;

interface MatchRepository
{
    public function save(Match $team): Match;
    public function findAvailableMatches();
    public function findById(int $id): Match;
    public function findFinishedMatches();
}
