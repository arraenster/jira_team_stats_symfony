<?php

namespace App\Entity;

use App\Interfaces\Entity\CustomEntityInterface;

class CustomIssue implements CustomEntityInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string`
     */
    protected $assignee;

    /**
     * @var int
     */
    protected $storyPoints;

    /**
     * @var string
     */
    protected $status;

    /**
     * @return int
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param int $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getAssignee(): string
    {
        return $this->assignee;
    }

    /**
     * @param string $assignee
     */
    public function setAssignee(string $assignee): void
    {
        $this->assignee = $assignee;
    }

    /**
     * @return int
     */
    public function getStoryPoints(): int
    {
        return $this->storyPoints;
    }

    /**
     * @param int $storyPoints
     */
    public function setStoryPoints(int $storyPoints): void
    {
        $this->storyPoints = $storyPoints;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
