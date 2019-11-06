<?php

namespace Spacestack\Rockly\Domain;

use Doctrine\ORM\Mapping as ORM;
use Spacestack\Rockly\Domain\Events\MatchResultEntered;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="integer")
     */
    private $pointA;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $pointB;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\Team")
     * @ORM\JoinColumn(name="team_b_id", referencedColumnName="id")
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
        $this->teamA = $teamA;
        $this->teamB = $teamB;
        $this->oddsA = $oddsA;
        $this->oddsB = $oddsB;
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

        $this->pointA = $pointA;
        $this->pointB = $pointB;
        $this->winner = $winner;
        $this->dispatchEvent(new MatchResultEntered(
            $this->id,
            $pointA,
            $pointB,
            $winner
        ));
    }
}
