<?php

namespace Spacestack\Rockly\Domain\Repository;

use Spacestack\Rockly\Domain\Team;

interface TeamRepository
{
    public function save(Team $team): Team;
    public function findAll();
}
