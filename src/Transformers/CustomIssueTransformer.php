<?php

namespace App\Transformers;

use App\Entity\CustomIssue;
use App\Interfaces\Entity\CustomEntityInterface;
use JiraRestApi\Issue\IssueV3;

class CustomIssueTransformer
{
    public function transform(\JsonSerializable $issueV3): CustomEntityInterface
    {
        /** @var IssueV3 $issueV3 */
        $customIssue = new CustomIssue();

        $customIssue->setKey($issueV3->key);
        $customIssue->setAssignee($issueV3->fields->assignee->emailAddress);
        $customIssue->setStoryPoints(!empty($issueV3->fields->customFields['customfield_10028']) ? $issueV3->fields->customFields['customfield_10028'] : 0);
        $customIssue->setStatus($issueV3->fields->status->name);

        return $customIssue;
    }
}
