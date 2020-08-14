<?php

namespace App\Controller;

use App\Services\JiraIssueService;
use App\Services\TeamStatsService;
use JiraRestApi\JiraException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Transformers\CustomIssueTransformer;

class DashboardController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @Route("/dashboard/{sprintId}", name="dashboard", requirements={"sprintId"="\d+"}, defaults={1})
     *
     * @param int $sprintId
     * @param JiraIssueService $jiraIssueService
     * @return Response
     * @throws \JsonMapper_Exception
     */
    public function index(int $sprintId, JiraIssueService $jiraIssueService): Response
    {
        $sprintIssues = $errors = [];
        try {
            $sprintIssues = $jiraIssueService->getIssuesPerSprint($sprintId);
        } catch (JiraException $je) {
            $this->logger->error($je->getMessage());
            $errors[] = 'Something went wrong.';
        }

        return $this->render(
            'dashboard/index.html.twig',
            [
                'errors' => $errors,
                'issues' => $sprintIssues,
            ]
        );
    }

    /**
     * @Route("/dashboard/sprint/{sprintId}", name="dashboard_sprint", requirements={"sprintId"="\d+"}, defaults={1})
     *
     * @param int $sprintId
     * @param TeamStatsService $teamStatsService
     * @return Response
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
    public function sprint(int $sprintId, TeamStatsService $teamStatsService): Response
    {
        $errors = [];

        $sprint = $teamStatsService->getStoryPointsByDeveloperPerSprint($sprintId);

        return $this->render(
            'dashboard/sprint.html.twig',
            [
                'errors' => $errors,
                'sprint' => $sprint,
            ]
        );
    }
}
