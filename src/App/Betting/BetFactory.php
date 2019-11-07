<?php

namespace Spacestack\Rockly\App\Betting;

use Spacestack\Rockly\Infrastructure\DTO\Bet as BetDTO;
use Spacestack\Rockly\Domain\Bet\BetItem;
use Spacestack\Rockly\Infrastructure\DTO\BetItem as BetItemDTO;
use Spacestack\Rockly\Domain\Bet;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Repository\BetRepository;
use Spacestack\Rockly\Domain\Repository\MatchRepository;
use Spacestack\Rockly\Domain\Repository\TeamRepository;

class BetFactory
{
    private $betRepository;
    private $matchRepository;
    private $teamRepository;

    public function __construct(
        BetRepository $betRepository,
        MatchRepository $matchRepository,
        TeamRepository $teamRepository
    ) {
        $this->betRepository = $betRepository;
        $this->matchRepository = $matchRepository;
        $this->teamRepository = $teamRepository;
    }

    public function createBetItem(Bet $bet, BetItemDTO $dto)
    {
        $betItem = $this->betRepository->saveBetItem(
            new BetItem(
                $bet,
                $this->matchRepository->findById($dto->matchId),
                $this->teamRepository->findById($dto->teamId)
            )
        );

        return $betItem;
    }

    public function createBet(BetDTO $dto, User $user): Bet
    {
        $bet = $this->betRepository->save(new Bet($user, $dto->amount));

        return $bet;
    }
}
