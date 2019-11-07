<?php

namespace Spacestack\Rockly\App\Handlers;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Spacestack\Rockly\App\BettingService;
use Spacestack\Rockly\Domain\Events\BetItemSolved;

class BetItemSolvedHandler implements MessageHandlerInterface
{
    public $bettingService;

    public function __construct(BettingService $bettingService)
    {
        $this->bettingService = $bettingService;
    }

    public function __invoke(BetItemSolved $event)
    {
        $this->bettingService->resolveBet($event->getBetId());
    }
}
