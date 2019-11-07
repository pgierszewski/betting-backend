<?php

namespace Spacestack\Rockly\UI\Controller\Rest;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Spacestack\Rockly\Infrastructure\DTO\In\Match;
use Spacestack\Rockly\App\MatchService;
use Spacestack\Rockly\Infrastructure\Response\ResponseBuilder;
use Spacestack\Rockly\Infrastructure\DTO\Result;

class MatchController
{
    private $matchService;
    private $responseBuilder;

    public function __construct(MatchService $matchService, ResponseBuilder $responseBuilder)
    {
        $this->matchService = $matchService;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @Route("/api/turbosekreturl/match", methods={"POST"}, name="api_match_add")
     */
    public function addMatch(Match $match): Response
    {
        return $this->responseBuilder->build(
            $this->matchService->create($match),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/turbosekreturl/match/{matchId}", methods={"POST"}, name="api_match_set_result")
     */
    public function setResult(Result $result, int $matchId): Response
    {
        return $this->responseBuilder->build(
            $this->matchService->setResult($result, $matchId)
        );
    }

    /**
     * @Route("/api/match", methods={"GET"}, name="api_match_get_available")
     */
    public function getAvailableMatches(): Response
    {
        return $this->responseBuilder->build(
            $this->matchService->getAvailableMatches()
        );
    }
}
