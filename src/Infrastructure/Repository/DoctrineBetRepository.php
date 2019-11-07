<?php

namespace Spacestack\Rockly\Infrastructure\Repository;

use Spacestack\Rockly\Domain\Repository\BetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Match;
use Spacestack\Rockly\Domain\Bet\BetItem;
use Spacestack\Rockly\Domain\Bet;
use Symfony\Component\Messenger\MessageBusInterface;
use Spacestack\Rockly\Domain\EventStore;
use Symfony\Component\Serializer\SerializerInterface;

class DoctrineBetRepository implements BetRepository
{
    private $em;
    private $eventBus;
    private $serializer;

    public function __construct(
        EntityManagerInterface $em,
        MessageBusInterface $eventBus,
        SerializerInterface $serializer
    ) {
        $this->em = $em;
        $this->eventBus = $eventBus;
        $this->serializer = $serializer;
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

        foreach ($betItem->releaseEvents() as $event) {
            $this->eventBus->dispatch($event);
            $this->em->persist(
                new EventStore(
                    $betItem->getId(),
                    BetItem::class,
                    get_class($event),
                    $this->serializer->serialize($event, 'json')
                )
            );
            $this->em->flush();
            $this->eventBus->dispatch($event);
        }

        return $betItem;
    }

    public function getBetsByUser(User $user)
    {
        
    }

    public function getBetsByMatch(Match $user)
    {
        
    }
}
