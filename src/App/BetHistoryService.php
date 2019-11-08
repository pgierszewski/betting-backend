<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\Infrastructure\DTO\Out\BetHistory;
use Spacestack\Rockly\Infrastructure\DTO\Out\BetHistoryItem;
use Spacestack\Rockly\Domain\Repository\BetRepository;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Team;

class BetHistoryService
{
    private $betRepository;

    public function __construct(BetRepository $betRepository)
    {
        $this->betRepository = $betRepository;
    }

    public function getBetHistory(User $user): array
    {
        $bets = $this->betRepository->getBetsByUser($user);
        $collection = [];

        foreach ($bets as $bet) {
            $betHistory = new BetHistory;
            $betHistory->successful = $bet->getSuccessful();
            $betHistory->winnings = $bet->getWinnings();
            $betHistory->occuredOn = $bet->getOccuredOn()->format('Y-m-d H:i:s');
            $betHistory->resolvedOn = $bet->getResolvedOn() ? $bet->getResolvedOn()->format('Y-m-d H:i:s') : null;
            foreach ($bet->getItems() as $item) {
                $betHistoryItem = new BetHistoryItem;
                $betHistoryItem->successful = $item->getSuccessful();
                $betHistoryItem->teamA = $this->parseTeamName($item->getMatch()->getTeamA());
                $betHistoryItem->teamB = $this->parseTeamName($item->getMatch()->getTeamB());
                $betHistoryItem->odds = $item->getOdds();
                $betHistoryItem->type = $this->parseTeamName($item->getType());
                $betHistory->items[] = $betHistoryItem;
            }
            $collection[] = $betHistory;
        }

        return $collection;
    }

    private function parseTeamName(Team $team): string
    {
        return sprintf(
            '%s / %s',
            $team->getPlayerA(),
            $team->getPlayerB()
        );
    }
}
