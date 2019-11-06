<?php

namespace Spacestack\Rockly\Infrastructure\Repository;

use Spacestack\Rockly\Domain\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\Team;

class DoctrineTeamRepository implements TeamRepository
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Team $team): Team
    {
        $this->em->persist($team);
        $this->em->flush();

        return $team;
    }

    public function findAll()
    {
        return $this->em
            ->getRepository(Team::class)
            ->findAll();
    }
}
