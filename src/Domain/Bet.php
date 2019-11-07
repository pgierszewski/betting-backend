<?php

namespace Spacestack\Rockly\Domain;

use Doctrine\ORM\Mapping as ORM;
use Spacestack\Rockly\Domain\Bet\BetItem;
use Spacestack\Rockly\Domain\Events\BetPlaced;

/**
 * @ORM\Entity
 */
class Bet extends AggregateRoot
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

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime")
     */
    private $occuredOn;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $resolvedOn;

    public function __construct(User $user, int $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->occuredOn = new \DateTimeImmutable();
        $this->dispatchEvent(
            new BetPlaced($amount)
        );
    }

    public function solveBet(bool $successful, int $winnings)
    {
        $this->successful = $successful;
        $this->winnings = $winnings;
        $this->resolvedOn = new \DateTimeImmutable();
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
