<?php

namespace Spacestack\Rockly\Domain;

use Doctrine\ORM\Mapping as ORM;
use Spacestack\Rockly\Domain\Bet\BetItem;

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
     * @var BetItem[]
     * @ORM\OneToMany(targetEntity="Spacestack\Rockly\Domain\Bet\BetItem", mappedBy="bet")
     */
    private $items;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $winnings;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $successful;

    public function __construct(User $user, array $betItems, int $amount)
    {
        foreach ($betItems as $item) {
            if ($item->match->winner) {
                throw new DomainException("You can't place a bet to a finished match");
            }
        }
        
        $this->user = $user;
        $this->items = $betItems;
        $this->amount = $amount;
    }

    public function solveBet(bool $successful, int $winnings)
    {
        $this->successful = $successful;
        $this->winnings = $winnings;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getSuccessful(): bool
    {
        return $this->successful;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getWinnings(): int
    {
        return $this->winnings;
    }
}
