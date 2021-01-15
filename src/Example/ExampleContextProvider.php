<?php

declare(strict_types=1);

namespace Doctrine\SQLCommenter\Example;

use Doctrine\SQLCommenter\ContextProvider;

final class ExampleContextProvider implements ContextProvider
{
    /** @var array<string,string> */
    private $context = [];

    /**
     * @param array<string,string> $context
     */
    public function enterContext(array $context): void
    {
        $this->context = $context;
    }

    public function leaveContext(): void
    {
        $this->context = [];
    }

    /**
     * {@inheritDoc}
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
