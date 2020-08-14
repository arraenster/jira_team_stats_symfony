<?php

namespace App\Interfaces\Transformers;

use App\Interfaces\Entity\CustomEntityInterface;

interface TransformerInterface
{
    public function transform(\JsonSerializable $item): CustomEntityInterface;
}
