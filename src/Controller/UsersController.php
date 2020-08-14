<?php

namespace App\Controller;

use App\Entity\CustomUser;
use App\Services\JiraUserService;
use App\Transformers\CustomUserTransformer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CustomUserRepository;
use Psr\Log\LoggerInterface;

class UsersController extends AbstractController
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var CustomUserRepository
     */
    protected $customUserRepository;

    function __construct(
        LoggerInterface $logger,
        CustomUserRepository $customUserRepository
    ) {
        $this->logger = $logger;
        $this->customUserRepository = $customUserRepository;
    }

    /**
     * @Route("/users", name="users")
     *
     * @param JiraUserService $jiraUserService
     * @return Response
     */
    public function users(JiraUserService $jiraUserService): Response
    {
        $users = $errors = [];

        try {
            $users = $jiraUserService->getAllUsersFromJira();

            $entityManager = $this->getDoctrine()->getManager();

            foreach ($users as $user) {
                /** @var CustomUser $user */
                /** @var CustomUser $userInDB */
                $userInDB = $this->customUserRepository->findOneBy(['email' => $user->getEmail()]);
                if (empty($userInDB)) {
                    $entityManager->persist($user);
                } else {
                    $userInDB->setKey($user->getKey());
                    $userInDB->setName($user->getName());
                    $userInDB->setActive($user->getActive());

                    $userInDB->setUpdateTime(new \DateTimeImmutable('now'));
                }
            }

            $entityManager->flush();;

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $errors[] = 'Something went wrong.';
        }

        return $this->render(
            'users/index.html.twig',
            [
                'errors' => $errors,
                'users' => $users,
            ]
        );
    }
}
