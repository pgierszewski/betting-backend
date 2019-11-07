<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\Infrastructure\DTO\In\Match as MatchDTO;
use Spacestack\Rockly\Infrastructure\DTO\Out\Match as MatchOutDTO;
use Spacestack\Rockly\Domain\Match;
use Spacestack\Rockly\Domain\Repository\TeamRepository;
use Spacestack\Rockly\Domain\Repository\MatchRepository;
use Spacestack\Rockly\Infrastructure\DTO\Result;

class MatchService
{
    private $teamRepository;
    private $matchRepository;

    public function __construct(
        TeamRepository $teamRepository,
        MatchRepository $matchRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->matchRepository = $matchRepository;
    }

    public function create(MatchDTO $dto)
    {
        $teamA = $this->teamRepository->findById($dto->teamAId);
        $teamB = $this->teamRepository->findById($dto->teamBId);

        $match = new Match($teamA, $teamB, $dto->oddsA, $dto->oddsB);
        $match = $this->matchRepository->save($match);
    }

    public function setResult(Result $dto, int $matchId)
    {
        $match = $this->matchRepository->findById($matchId);
        $winner = $this->teamRepository->findById($dto->winnerId);

        $match->setResult($dto->pointA, $dto->pointB, $winner);
        $this->matchRepository->save($match);
    }

    public function getAvailableMatches()
    {
        $matches = $this->matchRepository->findAvailableMatches();
        $collection = [];
        
        foreach ($matches as $match) {
            $dto = new MatchOutDTO;
            $dto->teamNameA = sprintf(
                '%s / %s',
                $match->getTeamA()->getPlayerA(),
                $match->getTeamA()->getPlayerB()
            );
            $dto->teamNameB = sprintf(
                '%s / %s',
                $match->getTeamB()->getPlayerA(),
                $match->getTeamB()->getPlayerB()
            );
            $dto->oddsA = $match->getOddsA();
            $dto->oddsB = $match->getOddsB();

            $collection[] = $dto;
        }

        return $collection;
    }
}
