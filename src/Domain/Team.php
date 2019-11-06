<?php

namespace Spacestack\Rockly\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Team
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
    private $playerA;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $playerB;

    public function __construct(string $playerA, string $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayerA(): string
    {
        return $this->playerA;
    }

    public function getPlayerB(): string
    {
        return $this->playerB;
    }
}
