<?php

declare(strict_types=1);

namespace Doctrine\SQLCommenter;

use function var_export;

final class Commenter
{
    /** @var ContextProvider */
    private $contextProvider;

    public function __construct(ContextProvider $contextProvider)
    {
        $this->contextProvider = $contextProvider;
    }

    public function augment(string $sql): string
    {
        $context = $this->contextProvider->getContext();

        if ($context === []) {
            return $sql;
        }

        return $sql . ' /* ' . var_export($context, true) . ' */';
    }
}
