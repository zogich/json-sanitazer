<?php

declare(strict_types=1);

namespace common;

interface CompositeInterface
{
    public function addChild(SanitazerInterface $child): void;
}
