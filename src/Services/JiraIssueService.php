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
     * @var CustomIssueTransformer
     */
    protected $customIssueTransformer;

    /**
     * JiraIssueService constructor.
     * @param CustomIssueTransformer $customIssueTransformer
     * @param ConfigurationInterface|null $configuration
     * @param LoggerInterface|null $logger
     * @param string $path
     * @throws JiraException
     */
    function __construct(
        CustomIssueTransformer $customIssueTransformer,
        ConfigurationInterface $configuration = null,
        LoggerInterface $logger = null,
        $path = './'
    ) {

        $this->customIssueTransformer = $customIssueTransformer;

        parent::__construct($configuration, $logger, $path);
    }

    /**
     * @param int $sprintId

     * @return array
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
    public function getIssuesPerSprint(int $sprintId): array
    {
        $result = $this->search('sprint = ' . $sprintId);

        $jiraIssues = [];
        foreach ($result->getIssues() as $issue)
        {
            /** @var IssueV3 $issue */
            $jiraIssues[] = $this->customIssueTransformer->transform($issue);

        }
        return $jiraIssues;
    }

}
