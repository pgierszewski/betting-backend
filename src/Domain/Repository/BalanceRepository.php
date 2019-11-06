<?php

namespace Spacestack\Rockly\Domain\Repository;

use Spacestack\Rockly\Domain\User;

interface BalanceRepository
{
    public function getBalanceByUser(User $user);

    public function getBalanceHistory(User $user);
}
