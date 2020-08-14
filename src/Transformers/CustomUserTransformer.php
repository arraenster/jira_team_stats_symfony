<?php

namespace App\Transformers;

use App\Entity\CustomUser;
use App\Interfaces\Entity\CustomEntityInterface;
use App\Interfaces\Transformers\TransformerInterface;
use JiraRestApi\User\User;

class CustomUserTransformer implements TransformerInterface
{
    public function transform(\JsonSerializable $user): CustomEntityInterface
    {
        /** @var User $user */
        $customUser = new CustomUser();

        $customUser->setEmail($user->emailAddress);
        $customUser->setActive((int) $user->active);
        $customUser->setName($user->displayName);
        $customUser->setKey($user->key);

        return $customUser;
    }
}
