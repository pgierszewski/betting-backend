<?php

namespace Spacestack\Rockly\Domain;

/**
 * @ORM\Entity
 */
class Bet
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Spacestack\Rockly\Domain\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
    private $bet;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $succesfull;

    public function __construct(User $user, Match $match, Team $bet, int $amount)
    {
        if ($match->winner) {
            throw new DomainException("You can't place a bet to a finished match");
        }
        $this->user = $user;
        $this->match = $match;
        $this->bet = $bet;
        $this->amount = $amount;
    }

    public function setSuccessfull(bool $succesfull)
    {
        $this->succesfull = $succesfull;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMatch(): Match
    {
        return $this->match;
    }

    public function getBet(): Team
    {
        return $this->bet;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getSuccesfull(): bool
    {
        return $this->won;
    }
}
