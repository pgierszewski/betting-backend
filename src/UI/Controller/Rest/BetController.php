<?php

namespace Spacestack\Rockly\UI\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;
use Spacestack\Rockly\Infrastructure\DTO\Bet;
use Spacestack\Rockly\Infrastructure\Response\ResponseBuilder;
use Spacestack\Rockly\App\BettingService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class BetController
{
    private $responseBuilder;
    private $bettingService;

    public function __construct(ResponseBuilder $responseBuilder, BettingService $bettingService)
    {
        $this->responseBuilder = $responseBuilder;
        $this->bettingService = $bettingService;
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
        return new Response(
            $this->bettingService->placeBet($bet, $user),
            Response::HTTP_CREATED
        );
    }
}
