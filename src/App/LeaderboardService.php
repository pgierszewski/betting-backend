<?php

namespace Spacestack\Rockly\App;

use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Infrastructure\DTO\Out\Player;

class LeaderboardService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getLeaderboards(): array
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
            ->from(User::class, 'u')
            ->join('u.balance', 'b')
            ->orderBy('b.balance', 'DESC');

        $players = $qb->getQuery()->getResult();

        $collection = [];
        $i=1;
        foreach ($players as $player) {
            $dto = new Player;
            $dto->position = $i++;
            $dto->email = $player->getEmail();
            $dto->balance = $player->getBalance()->getBalance();
            $collection[] = $dto;
        }

        return $collection;
    }
}
