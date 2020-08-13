<?php

namespace App\Entity;

class CustomIssue
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

}
