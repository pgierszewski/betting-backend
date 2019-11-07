<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\App\Betting\BetFactory;
use Spacestack\Rockly\Infrastructure\DTO\Bet as BetDTO;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Repository\BalanceRepository;
use Spacestack\Rockly\Domain\Repository\MatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\DomainException;
use Spacestack\Rockly\Domain\Events\MatchResultEntered;
use Spacestack\Rockly\Domain\Bet\BetItem;
use Spacestack\Rockly\Domain\Repository\BetRepository;
use Spacestack\Rockly\Domain\Events\BetItemSolved;
use Spacestack\Rockly\Domain\Bet;

class BettingService
{
    private $betFactory;
    private $balanceRepository;
    private $matchRepository;
    private $betRepository;
    private $em;

    public function __construct(
        BetFactory $betFactory,
        BalanceRepository $balanceRepository,
        MatchRepository $matchRepository,
        EntityManagerInterface $em,
        BetRepository $betRepository
    ) {
        $this->betFactory = $betFactory;
        $this->balanceRepository = $balanceRepository;
        $this->matchRepository = $matchRepository;
        $this->em = $em;
        $this->betRepository = $betRepository;
    }

    public function placeBet(BetDTO $dto, User $user)
    {
        if (empty($dto->betItems)) {
            throw new DomainException("No bet items");
        }

        $balance = $user->getBalance();
        if ($balance->getBalance() < $dto->amount) {
            throw new DomainException("Insufficient balance");
        }

        foreach ($dto->betItems as $item) {
            $match = $this->matchRepository->findById($item->matchId);
            if ($match->isResolved()) {
                throw new DomainException("One or more matches are already finished.");
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

    public function resolveBetItems(int $matchId, int $winnerId)
    {
        $match = $this->matchRepository->findById($matchId);
        if (!$match) {
            return;
        }
        $betItems = $this->em
            ->getRepository(BetItem::class)
            ->findBy(['match' => $match]);

        foreach ($betItems as $item) {
            $item->setSuccessful($winnerId === $item->getType()->getId());
            $this->betRepository->saveBetItem($item);
        }
    }

    public function resolveBet(int $betId)
    {
        $bet = $this->em
            ->getRepository(Bet::class)
            ->findOneBy(['id' => $betId]);

        if (false === $bet->getSuccessful()) {
            return;
        }

        $odds = 1;
        foreach ($bet->getItems() as $item) {
            if (false === $item->getSuccessful()) {
                $bet->solveBet(false, 0);
                $this->betRepository->save($bet);
                return;
            }
        }

        foreach ($bet->getItems() as $item) {
            if (null === $item->getSuccessful()) {
                return;
            }

            $odds *= $item->getOdds();
        }
        $this->em->getConnection()->beginTransaction();
        $winnings = (int)($bet->getAmount() * $odds);
        $bet->solveBet(
            true,
            $winnings
        );
        $this->betRepository->save($bet);
        $balance = $bet->getUser()->getBalance();
        $balance->addBalance($winnings);
        $this->balanceRepository->save($balance);

        $this->em->getConnection()->commit();
    }
}
