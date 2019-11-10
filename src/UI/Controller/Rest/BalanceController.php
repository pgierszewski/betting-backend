<?php

namespace Spacestack\Rockly\UI\Controller\Rest;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
}
