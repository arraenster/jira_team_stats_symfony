<?php

namespace App\Transformers;

use App\Entity\CustomIssue;
use JiraRestApi\Issue\IssueV3;

class CustomIssueTransformer
{
    public function transform(IssueV3 $issueV3): CustomIssue
    {
        $customIssue = new CustomIssue();

        $customIssue->setKey($issueV3->key);
        $customIssue->setAssignee($issueV3->fields->assignee->emailAddress);

        return $customIssue;
    }
}
