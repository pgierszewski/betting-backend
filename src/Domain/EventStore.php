<?php

namespace Spacestack\Rockly\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EventStore
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $entityClass;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $entityId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $eventType;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $event;

    /**
     * \DateTimeImmutable
     * @ORM\Column(type="datetime")
     */
    private $occuredOn;

    public function __construct(int $entityId, string $entityClass, string $eventType, string $event)
    {
        $this->entityId = $entityId;
        $this->entityClass = $entityClass;
        $this->eventType = $eventType;
        $this->event = $event;
        $this->occuredOn = new \DateTimeImmutable();
    }
}
