<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\Infrastructure\DTO\Team as TeamDTO;
use Spacestack\Rockly\Domain\Repository\TeamRepository;
use Spacestack\Rockly\Domain\Team;
use Doctrine\ORM\EntityManagerInterface;

class TeamService
{
    private $em;
    private $repository;

    public function __construct(EntityManagerInterface $em, TeamRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function create(TeamDTO $dto): TeamDTO
    {
        $team = new Team(
            $dto->playerA,
            $dto->playerB
        );

        $team = $this->repository->save($team);
        $dto->id = $team->getId();

        return $dto;
    }

    public function getAllTeams(): array
    {
        $teams = $this->repository->findAll();
        $collection = [];

        foreach ($teams as $team) {
            $dto = new TeamDTO;
            $dto->id = $team->getId();
            $dto->playerA = $team->getPlayerA();
            $dto->playerB = $team->getPlayerB();
            $collection[] = $dto;
        }
        
        return $collection;
    }
}
