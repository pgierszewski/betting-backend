<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\App\Betting\BetFactory;
use Spacestack\Rockly\Infrastructure\DTO\Bet as BetDTO;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Repository\BalanceRepository;
use Spacestack\Rockly\Domain\Repository\MatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class BettingService
{
    private $betFactory;
    private $balanceRepository;
    private $matchRepository;
    private $em;

    public function __construct(
        BetFactory $betFactory,
        BalanceRepository $balanceRepository,
        MatchRepository $matchRepository,
        EntityManagerInterface $em
    ) {
        $this->betFactory = $betFactory;
        $this->balanceRepository = $balanceRepository;
        $this->matchRepository = $matchRepository;
        $this->em = $em;
    }

    public function placeBet(BetDTO $dto, User $user)
    {
        if (empty($dto->betItems)) {
            throw new \Exception("No bet items");
        }

        $balance = $user->getBalance();
        if ($balance->getBalance() < $dto->amount) {
            throw new \Exception("Insufficient balance");
        }

        foreach ($dto->betItems as $item) {
            $match = $this->matchRepository->findById($item->matchId);
            if ($match->isResolved()) {
                throw new \Exception("One or more matches are already finished.");
            }
        }

        $this->em->getConnection()->beginTransaction();
        try {
            $bet = $this->betFactory->createBet($dto, $user);
            foreach ($dto->betItems as $betItem) {
                $this->betFactory->createBetItem($bet, $betItem);
            }

            $balance->subBalance($dto->amount);
            $this->balanceRepository->save($balance);
            $this->em->getConnection()->commit();
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollback();
            throw $e;
        }
    }

    public function resolveBets()
    {
        
    }
}
