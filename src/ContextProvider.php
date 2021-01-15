<?php

declare(strict_types=1);

namespace Doctrine\SQLCommenter;

interface ContextProvider
{
    /**
     * @return array<string, string>
     */
    public function getContext(): array;
}
