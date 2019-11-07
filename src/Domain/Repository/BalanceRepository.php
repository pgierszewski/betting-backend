<?php

namespace Spacestack\Rockly\Domain\Repository;

use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Balance;

interface BalanceRepository
{
    public function save(Balance $balance): Balance;
    public function getBalanceByUser(User $user);
    public function getBalanceHistory(User $user);
}
