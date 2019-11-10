<?php

namespace Spacestack\Rockly\App;

use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;
use Spacestack\Rockly\Infrastructure\DTO\Out\Player;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LeaderboardService
{
    private $em;
    private $cache;
    private $serializer;

    public function __construct(
        EntityManagerInterface $em,
        AdapterInterface $cache,
        SerializerInterface $serializer
    ) {
        $this->em = $em;
        $this->cache = $cache;
        $this->serializer = $serializer;
    }

    public function getLeaderboards(): array
    {
        $cacheKey = 'leaderboards';
        $item = $this->cache->getItem($cacheKey);

        if ($item->isHit()) {
            return $this->serializer->deserialize(
                $item->get(),
                Player::class . '[]',
                'json'
            );
        }


        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
            ->from(User::class, 'u')
            ->join('u.balance', 'b')
            ->orderBy('b.balance', 'DESC');
        $players = $qb->getQuery()->getResult();

        $collection = [];
        $i=1;
        foreach ($players as $player) {
            $dto = new Player;
            $dto->position = $i++;
            $dto->email = $player->getEmail();
            $dto->balance = $player->getBalance()->getBalance();
            $collection[] = $dto;
        }

        $item->expiresAfter(new \DateInterval('PT3600S'));
        $item->set($this->serializer->serialize($collection, 'json'));
        $this->cache->save($item);

        return $collection;
    }
}
