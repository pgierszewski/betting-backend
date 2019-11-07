<?php

namespace Spacestack\Rockly\Infrastructure\Repository;

use Spacestack\Rockly\Domain\Repository\BalanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Balance;
use Symfony\Component\Serializer\SerializerInterface;
use Spacestack\Rockly\Domain\EventStore;
use Symfony\Component\Messenger\MessageBusInterface;

class DoctrineBalanceRepository implements BalanceRepository
{
    private $em;
    private $serializer;
    private $eventBus;

    public function __construct(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        MessageBusInterface $eventBus
    ) {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->eventBus = $eventBus;
    }

    public function save(Balance $balance): Balance
    {
        $this->em->persist($balance);
        $this->em->flush();

        foreach ($balance->releaseEvents() as $event) {
            $this->em->persist(
                new EventStore(
                    $balance->getId(),
                    Balance::class,
                    get_class($event),
                    $this->serializer->serialize($event, 'json')
                )
            );
            $this->em->flush();
            $this->eventBus->dispatch($event);
        }

        return $balance;
    }

    public function getBalanceByUser(User $user)
    {
        
    }

    public function getBalanceHistory(User $user)
    {
        
    }
}
