<?php

namespace App\Services;

use App\Repository\CustomUserRepository;
use App\Transformers\CustomUserTransformer;
use JiraRestApi\Configuration\ConfigurationInterface;
use JiraRestApi\User\UserService;
use JiraRestApi\JiraException;
use Psr\Log\LoggerInterface;

class JiraUserService extends UserService
{

    /**
     * @var CustomUserTransformer
     */
    protected $customUserTransformer;

    function __construct(
        CustomUserTransformer $customUserTransformer,
        ConfigurationInterface $configuration = null,
        LoggerInterface $logger = null,
        $path = './'
    ) {

        $this->customUserTransformer = $customUserTransformer;

        parent::__construct($configuration, $logger, $path);
    }

    public function getAllUsersFromJira(): array
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
                $customUsers[] = $this->customUserTransformer->transform($user);
            }
        } catch (JiraException | \JsonMapper_Exception $je) {
            throw new \Exception($je->getMessage(), $je->getCode());
        }

        return $customUsers;
    }

    /**
     * @param CustomUserRepository $customUserRepository
     * @return array
     * @throws \Exception
     */
    public function getUsersFromDb(CustomUserRepository $customUserRepository): array
    {
        $users = $customUserRepository->findAll();
        if (empty($users)) {
            $users = $this->getAllUsersFromJira();
        }

        return $users;
    }
}
