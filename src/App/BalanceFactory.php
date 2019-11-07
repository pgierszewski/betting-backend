<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\Domain\EventStore;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Balance;
use Spacestack\Rockly\Domain\Repository\BalanceRepository;

class BalanceFactory
{
    private $balanceRepository;

    public function __construct(BalanceRepository $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function create(User $user): Balance
    {
        $balance = new Balance($user);
        $balance->addBalance(1000);
        $balance = $this->balanceRepository->save($balance);

        return $balance;
    }
}
