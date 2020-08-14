<?php

namespace App\Services;

use App\Transformers\CustomUserTransformer;
use JiraRestApi\Configuration\ConfigurationInterface;
use JiraRestApi\User\UserService;
use JiraRestApi\JiraException;
use Psr\Log\LoggerInterface;

class JiraUserService extends UserService
{
    function __construct(ConfigurationInterface $configuration = null, LoggerInterface $logger = null, $path = './')
    {
        parent::__construct($configuration, $logger, $path);
    }

    public function getAllUsers(CustomUserTransformer $customUserTransformer): array
    {
        $params = [
            //'username' => '*', // get all users.
            //'startAt' => 0,
            //'maxResults' => 1000,
            //'includeInactive' => true,
            //'property' => '%',
            'query' => '+'
        ];

        $customUsers = [];
        try {
            $users = $this->findUsers($params);

            foreach ($users as $user) {
                $customUsers[] = $customUserTransformer->transform($user);
            }
        } catch (JiraException | \JsonMapper_Exception $je) {
            throw new \Exception($je->getMessage(), $je->getCode());
        }

        return $customUsers;
    }
}
