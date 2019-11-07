<?php

namespace Spacestack\Rockly\Infrastructure\Repository;

use Spacestack\Rockly\Domain\Repository\MatchRepository;
use Spacestack\Rockly\Domain\Match;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Spacestack\Rockly\Domain\EventStore;
use Symfony\Component\Serializer\SerializerInterface;

class DoctrineMatchRepository implements MatchRepository
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

    public function save(Match $match): Match
    {
        $this->em->persist($match);
        $this->em->flush();

        foreach ($match->releaseEvents() as $event) {
            $this->em->persist(
                new EventStore(
                    $match->getId(),
                    Match::class,
                    get_class($event),
                    $this->serializer->serialize($event, 'json')
                )
            );
            $this->em->flush();
            $this->eventBus->dispatch($event);
        }

        return $match;
    }

    public function findById(int $id): Match
    {
        return $this->em
            ->getRepository(Match::class)
            ->findOneBy(['id' => $id]);
    }

    public function findAvailableMatches()
    {
        return $this->em
            ->getRepository(Match::class)
            ->findBy(['winner' => null]);
    }
}
