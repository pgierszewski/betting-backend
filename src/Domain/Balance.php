<?php

namespace Spacestack\Rockly\Domain;

use Doctrine\ORM\Mapping as ORM;
use Spacestack\Rockly\Domain\Events\SubBalance;
use Spacestack\Rockly\Domain\Events\AddBalance;
use Spacestack\Rockly\Domain\Event;

/**
 * @ORM\Entity
 */
class Balance extends AggregateRoot
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
     * @var int
     * @ORM\Column(type="integer")
     */
    private $balance = 0;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function subBalance(int $amount)
    {
        if ($this->balance < $amount) {
            throw new DomainException("Insufficient balance");
        }

        $this->balance = $this->amount - $amount;
        $this->dispatchEvent(
            new SubBalance($amount)
        );
    }

    public function addBalance(int $amount)
    {
        $this->balance += $amount;
        $this->dispatchEvent(
            new AddBalance($amount)
        );
    }

    private function add(int $amount)
    {
        $this->balance += $amount;
    }

    private function sub(int $amount)
    {
        $this->balance -= $amount;
    }

    public function applyEvents(Event ...$events)
    {
        foreach ($events as $event) {
            $class = get_class($event);
            switch ($class) {
                case AddBalance::class:
                    $this->add($event->getAmount());
                    break;
                case SubBalance::class:
                    $this->sub($event->getAmount());
                    break;
                default:
                    throw new DomainException("Unknown event type");
                    break;
            }
        }
    }
}
