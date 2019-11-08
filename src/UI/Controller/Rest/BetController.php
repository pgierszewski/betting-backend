<?php

namespace Spacestack\Rockly\UI\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;
use Spacestack\Rockly\Infrastructure\DTO\Bet;
use Spacestack\Rockly\Infrastructure\Response\ResponseBuilder;
use Spacestack\Rockly\App\BettingService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Spacestack\Rockly\App\BetHistoryService;

class BetController
{
    private $responseBuilder;
    private $bettingService;
    private $betHistoryService;

    public function __construct(
        ResponseBuilder $responseBuilder,
        BettingService $bettingService,
        BetHistoryService $betHistoryService
    ) {
        $this->responseBuilder = $responseBuilder;
        $this->bettingService = $bettingService;
        $this->betHistoryService = $betHistoryService;
    }

    public function getHistory(): Response
    {
        return new Response();
    }

    /**
     * @Route("/api/secured/bet", methods={"post"}, name="api_bet_place")
     */
    public function palceBet(Bet $bet, UserInterface $user): Response
    {
        return $this->responseBuilder->build(
            $this->bettingService->placeBet($bet, $user),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/secured/bet", methods={"get"}, name="api_bet_get")
     */
    public function getBetHistory(UserInterface $user): Response
    {
        return $this->responseBuilder->build(
            $this->betHistoryService->getBetHistory($user)
        );
    }
}
