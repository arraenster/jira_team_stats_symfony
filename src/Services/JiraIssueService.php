<?php

namespace App\Services;

use App\Transformers\CustomIssueTransformer;
use JiraRestApi\Configuration\ConfigurationInterface;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\JiraException;
use App\Interfaces\Services\JiraServiceInterface;
use Psr\Log\LoggerInterface;
use JiraRestApi\Issue\IssueV3;

class JiraIssueService extends IssueService implements JiraServiceInterface
{

    function __construct(ConfigurationInterface $configuration = null, LoggerInterface $logger = null, $path = './')
    {
        parent::__construct($configuration, $logger, $path);
    }

    public function getIssuesPerSprint(int $sprintId, CustomIssueTransformer $customIssueTransformer): array
    {
        $result = $this->search('sprint = ' . $sprintId);

        $jiraIssues = [];
        foreach ($result->getIssues() as $issue)
        {
            /** @var IssueV3 $issue */

            $jiraIssues[] = $customIssueTransformer->transform($issue);

        }
        return $jiraIssues;
    }

}
