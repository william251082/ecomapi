<?php

namespace App\Entity;

use DateTimeInterface;

interface PublishedDateEntityInterface
{
    public function setPublishedAt(DateTimeInterface $published): PublishedDateEntityInterface;
}