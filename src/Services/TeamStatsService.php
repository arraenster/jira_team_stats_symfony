<?php

namespace App\Services;

use App\Entity\CustomIssue;
use App\Entity\CustomUser;
use App\Entity\Sprint;
use App\Repository\CustomUserRepository;

class TeamStatsService
{

    /**
     * @var JiraIssueService
     */
    protected $jiraIssueService;

    /**
     * @var JiraUserService
     */
    protected $jiraUserService;

    /**
     * @var CustomUserRepository
     */
    protected $customUserRepository;

    /**
     * @var Sprint
     */
    protected $sprint;

    function __construct(
        JiraIssueService $jiraIssueService,
        JiraUserService $jiraUserService,
        CustomUserRepository $customUserRepository
    ) {
        $this->jiraIssueService = $jiraIssueService;
        $this->jiraUserService = $jiraUserService;
        $this->customUserRepository = $customUserRepository;
    }

    /**
     * @param int $sprintId
     * @return array
     * @throws \JiraRestApi\JiraException
     * @throws \JsonMapper_Exception
     */
    public function getStoryPointsByDeveloperPerSprint(int $sprintId): array
    {
        $issues = $this->jiraIssueService->getIssuesPerSprint($sprintId);
        $users = $this->jiraUserService->getUsersFromDb($this->customUserRepository);

        $sprint = new Sprint();

        foreach ($issues as $issue) {
            /** @var CustomIssue $issue */

            //$sprint[ $issue->getAssignee() ]['startOfSprint']['count'] += 1;
        }

        return [];
    }

//    public function getStoryPointsByDeveloper($sprint_id)
//    {
//
//        $this->sprintId = $sprint_id;
//        $users = [];
//
//        $sprint = $this->api->getSprint($sprint_id);
//
//        $this->sprintStartDate = date('Y-m-d H:i:s', strtotime($sprint['startDate']));
//        $this->sprintEndDate = date('Y-m-d H:i:s', strtotime($sprint['endDate']));
//        $this->sprintName = $sprint['name'];
//
//        echo $this->sprintStartDate . ' ' . $this->sprintName . '<br>';
//
//        $tasks = $this->_getSprintTasks($sprint_id);
//
//        if (empty($tasks))
//        {
//            return $users;
//        }
//
//        foreach ($tasks as $issueKey => $task)
//        {
//
//            $fields = $task->getFields();
//
//            if (strtotime($fields['Created']) > strtotime($this->sprintStartDate))
//            {
//                $isScopeChange = true;
//            } else
//            {
//                $isScopeChange = $this->_isScopeChange($issueKey);
//            }
//
//            if (!$isScopeChange)
//            {
//                $users[ $fields['Assignee']['name'] ]['startOfSprint']['count'] += 1;
//                $users[ $fields['Assignee']['name'] ]['startOfSprint']['sp'] += $fields['Story Points'];
//            }
//            else
//            {
//                $users[ $fields['Assignee']['name'] ]['startOfSprint']['count'] += 0;
//                $users[ $fields['Assignee']['name'] ]['startOfSprint']['sp'] += 0;
//            }
//
//            $users[ $fields['Assignee']['name'] ]['endOfSprint']['count'] += 1;
//            $users[ $fields['Assignee']['name'] ]['endOfSprint']['sp'] += $fields['Story Points'];
//
//            switch ($fields['Status']['name'])
//            {
//                case 'To Do':
//                case 'In Progress':
//                case 'In Testing (branch)':
//                case 'In Testing (master)':
//                    $users[ $fields['Assignee']['name'] ]['endOfSprint']['done']['count'] += 0;
//                    $users[ $fields['Assignee']['name'] ]['endOfSprint']['done']['sp'] += 0;
//                    break;
//                case 'Done':
//
//                    $users[ $fields['Assignee']['name'] ]['endOfSprint']['done']['count'] += 1;
//                    $users[ $fields['Assignee']['name'] ]['endOfSprint']['done']['sp'] += $fields['Story Points'];
//                    break;
//                default:
//                    $users[ $fields['Assignee']['name'] ]['endOfSprint']['done']['count'] += 0;
//                    $users[ $fields['Assignee']['name'] ]['endOfSprint']['done']['sp'] += 0;
//                    break;
//            }
//
//        }
//
//        ksort($users);
//        return $users;
//    }
}
