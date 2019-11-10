<?php

namespace Spacestack\Rockly\UI\Controller\Rest;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Spacestack\Rockly\Infrastructure\Response\ResponseBuilder;
use Spacestack\Rockly\App\LeaderboardService;

class BalanceController
{
    /**
     * @Route("/api/secured/balance", methods={"get"}, name="api_player_balance")
     */
    public function getBalance(UserInterface $user): JsonResponse
    {
        return new JsonResponse(
            ['balance' => $user->getBalance()->getBalance()]
        );
    }

    /**
     * @Route("/api/leaderboards", methods={"get"}, name="api_player_leaderboards")
     */
    public function getLeaderboards(ResponseBuilder $rb, LeaderboardService $ls)
    {
        return $rb->build(
            $ls->getLeaderboards()
        );
    }
}
