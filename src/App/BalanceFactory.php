<?php

namespace Spacestack\Rockly\App;

use Spacestack\Rockly\Domain\EventStore;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Domain\Balance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BalanceFactory
{
    private $em;
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    public function create(User $user): Balance
    {
        $balance = new Balance($user);
        $balance->addBalance(1000);
        
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
        }

        return $balance;
    }
}
