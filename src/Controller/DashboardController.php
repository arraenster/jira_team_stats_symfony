<?php

namespace App\Controller;

use App\Services\JiraIssueService;
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

    /**
     * @var CustomIssueTransformer
     */
    protected $customIssueTransformer;

    function __construct(
        LoggerInterface $logger,
        CustomIssueTransformer $customIssueTransformer
    ) {
        $this->logger = $logger;
        $this->customIssueTransformer = $customIssueTransformer;
    }

    /**
     * @Route("/dashboard/{sprintId}", name="dashboard", requirements={"sprintId"="\d+"}, defaults={1})
     *
     * @param int $sprintId
     * @param JiraIssueService $jiraIssueService
     * @return Response
     */
    public function index(int $sprintId, JiraIssueService $jiraIssueService): Response
    {
        $sprintIssues = $errors = [];
        try {
            $sprintIssues = $jiraIssueService->getIssuesPerSprint($sprintId, $this->customIssueTransformer);
        } catch (JiraException $je) {
            $this->logger->error($je->getMessage());
            $errors[] = 'Something went wrong.';
        }

        return $this->render('dashboard/index.html.twig', [
            'errors' => $errors,
            'issues' => $sprintIssues,
        ]);
    }
}
