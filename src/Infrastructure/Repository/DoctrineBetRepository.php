<?php

namespace Spacestack\Rockly\Infrastructure\Repository;

use Spacestack\Rockly\Domain\Repository\BetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Match;
use Spacestack\Rockly\Domain\Bet\BetItem;
use Spacestack\Rockly\Domain\Bet;

class DoctrineBetRepository implements BetRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Bet $bet): Bet
    {
        $this->em->persist($bet);
        $this->em->flush();

        return $bet;
    }

    public function saveBetItem(BetItem $betItem): BetItem
    {
        $this->em->persist($betItem);
        $this->em->flush();

        return $betItem;
    }

    public function getBetsByUser(User $user)
    {
        
    }

    public function getBetsByMatch(Match $user)
    {
        
    }
}
