<?php

namespace Spacestack\Rockly\App\Handlers;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Spacestack\Rockly\Domain\Events\MatchResultEntered;
use Spacestack\Rockly\App\BettingService;

class MatchResultEnteredHandler implements MessageHandlerInterface
{
    public $bettingService;

    public function __construct(BettingService $bettingService)
    {
        $this->bettingService = $bettingService;
    }

    public function __invoke(MatchResultEntered $event)
    {
        $this->bettingService->resolveBetItems($event->getMatchId(), $event->getWinnerId());
    }
}
