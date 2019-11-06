<?php

namespace Spacestack\Rockly\Infrastructure\Repository;

use Spacestack\Rockly\Domain\Repository\BalanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;

class DoctrineBalanceRepository implements BalanceRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getBalanceByUser(User $user)
    {
        
    }

    public function getBalanceHistory(User $user)
    {
        
    }
}
