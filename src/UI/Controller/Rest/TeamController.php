<?php

namespace Spacestack\Rockly\UI\Controller\Rest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Spacestack\Rockly\Infrastructure\DTO\Team;
use Spacestack\Rockly\Infrastructure\Response\ResponseBuilder;
use Spacestack\Rockly\App\TeamService;
use Spacestack\Rockly\Infrastructure\DTO\TeamCollection;

class TeamController
{
    private $responseBuilder;
    private $teamService;

    public function __construct(ResponseBuilder $builder, TeamService $teamService)
    {
        $this->responseBuilder = $builder;
        $this->teamService = $teamService;
    }

    /**
     * @Route("/api/turbosekreturl/team", methods={"POST"}, name="api_team_add")
     */
    public function addTeam(Team $team): Response
    {
        return $this->responseBuilder->build(
            $this->teamService->create($team),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/api/team", methods={"GET"}, name="api_team_get_all")
     */
    public function getTeams(): Response
    {
        return $this->responseBuilder->build(
            $this->teamService->getAllTeams()
        );
    }
}
