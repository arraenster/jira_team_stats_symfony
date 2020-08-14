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

    /**
     * JiraIssueService constructor.
     * @param ConfigurationInterface|null $configuration
     * @param LoggerInterface|null $logger
     * @param string $path
     * @throws JiraException
     */
    function __construct(ConfigurationInterface $configuration = null, LoggerInterface $logger = null, $path = './')
    {
        parent::__construct($configuration, $logger, $path);
    }

    /**
     * @param int $sprintId
     * @param CustomIssueTransformer $customIssueTransformer
     * @return array
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
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
