<?php

namespace App\Entity;

use App\Enum\EntityType;

abstract class BaseEntity
{
    abstract public function getEntityType(): EntityType;

    abstract public function getId(): ?int;
}
