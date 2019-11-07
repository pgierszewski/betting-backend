<?php

namespace Spacestack\Rockly\Domain\Bet;

use Doctrine\ORM\Mapping as ORM;
use Spacestack\Rockly\Domain\Match;
use Spacestack\Rockly\Domain\Team;
use Spacestack\Rockly\Domain\Bet;
use Zend\EventManager\Exception\DomainException;

/**
 * @ORM\Entity
 */
class BetItem
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Match
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\Match")
     * @ORM\JoinColumn(name="match_id", referencedColumnName="id")
     */
    private $match;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
    */
    private $type;

    /**
     * @var float
     * @ORM\Column(type="float")
    */
    private $odds;

    /**
     * @var Bet
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\Bet", inversedBy="items")
     * @ORM\JoinColumn(name="bet_id", referencedColumnName="id")
     */
    private $bet;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $successful;

    public function __construct(Bet $bet, Match $match, Team $type)
    {
        if ($type->getId() != $match->getTeamA()->getId()
            && $type->getId() != $match->getTeamB()->getId()
        ) {
            throw new DomainException("Invalid bet");
        }

        if ($type === $this->match->getTeamA()) {
            $this->odds = $this->match->getOddsA();
        } else {
            $this->odds = $this->match->getOddsB();
        }
        $this->bet = $bet;
        $this->match = $match;
        $this->type = $type;
    }

    public function setSuccessful(bool $successful): void
    {
        $this->successful = $successful;
    }

    public function getSuccessful(): bool
    {
        return $this->successful;
    }

    public function getMatch(): Match
    {
        return $this->match;
    }

    public function getType(): Team
    {
        return $this->type;
    }
}
