<?php

namespace Spacestack\Rockly\Infrastructure\Repository;

use Spacestack\Rockly\Domain\Repository\BetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Match;

class DoctrineBetRepository implements BetRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getBetsByUser(User $user)
    {
        
    }

    public function getBetsByMatch(Match $user)
    {
        
    }
}
