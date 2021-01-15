<?php

declare(strict_types=1);

namespace Doctrine\SQLCommenter;

use Doctrine\DBAL\Driver as DriverInterface;
use Doctrine\DBAL\Driver\Middleware as MiddlewareInterface;

final class Middleware implements MiddlewareInterface
{
    /** @var ContextProvider */
    private $contextProvider;

    public function __construct(ContextProvider $commenter)
    {
        $this->contextProvider = $commenter;
    }

    public function wrap(DriverInterface $driver): DriverInterface
    {
        return new Driver($driver, $this->contextProvider);
    }
}
