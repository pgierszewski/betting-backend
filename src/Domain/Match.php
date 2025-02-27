<?php

namespace Spacestack\Rockly\Domain;

use Doctrine\ORM\Mapping as ORM;
use Spacestack\Rockly\Domain\Events\MatchResultEntered;
use Spacestack\Rockly\Domain\Team;

/**
 * @ORM\Entity
 * @ORM\Table(name="matches")
 */
class Match extends AggregateRoot
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\Team")
     * @ORM\JoinColumn(name="team_a_id", referencedColumnName="id")
     */
    private $teamA;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\Team")
     * @ORM\JoinColumn(name="team_b_id", referencedColumnName="id")
     */
    private $teamB;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pointA;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pointB;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\Team")
     * @ORM\JoinColumn(name="winner_id", referencedColumnName="id")
     */
    private $winner;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $oddsA;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $oddsB;

    public function __construct(Team $teamA, Team $teamB, float $oddsA, float $oddsB)
    {
        if ($teamA == $teamB) {
            throw new DomainException("You can't create match with same team");
        }
        $this->teamA = $teamA;
        $this->teamB = $teamB;
        $this->oddsA = $oddsA;
        $this->oddsB = $oddsB;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTeamA(): Team
    {
        return $this->teamA;
    }

    public function getTeamB(): Team
    {
        return $this->teamB;
    }

    public function getOddsA(): float
    {
        return $this->oddsA;
    }

    public function getOddsB(): float
    {
        return $this->oddsB;
    }

    public function getPointA(): int
    {
        return $this->pointA;
    }

    public function getPointB(): int
    {
        return $this->pointB;
    }

    public function getWinner(): Team
    {
        return $this->winner;
    }

    public function isResolved(): bool
    {
        return ($this->winner != null);
    }

    public function changeTeams(Team $teamA, Team $teamB)
    {
        $this->teamA = $teamA;
        $this->teamB = $teamB;
    }

    public function setOdds(float $oddsA, float $oddsB)
    {
        $this->oddsA = $oddsA;
        $this->oddsB = $oddsB;
    }

    public function setResult(int $pointA, int $pointB, Team $winner)
    {
        if (!$this->id) {
            throw new DomainException("Setting result for non existing match");
        }

        if ($winner->getId() !== $this->getTeamA()->getId()
            && $winner->getId() !== $this->getTeamB()->getId()) {
                throw new DomainException("Winner is not in this match");
        }

        $this->pointA = $pointA;
        $this->pointB = $pointB;
        $this->winner = $winner;
        $this->dispatchEvent(new MatchResultEntered(
            $this->id,
            $pointA,
            $pointB,
            $winner->getId()
        ));
    }
}
