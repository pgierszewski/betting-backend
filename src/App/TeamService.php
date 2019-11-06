<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\Infrastructure\DTO\Team as TeamDTO;
use Spacestack\Rockly\Domain\Team;
use Doctrine\ORM\EntityManagerInterface;

class TeamService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(TeamDTO $dto): TeamDTO
    {
        $team = new Team(
            $dto->playerA,
            $dto->playerB
        );

        $this->em->persist($team);
        $this->em->flush();

        $dto->id = $team->getId();

        return $dto;
    }

    public function getTeams(): array
    {
        return [];
    }
}
