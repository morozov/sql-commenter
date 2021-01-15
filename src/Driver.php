<?php

declare(strict_types=1);

namespace Doctrine\SQLCommenter;

use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\Driver as DriverInterface;
use Doctrine\DBAL\Driver\API\ExceptionConverter;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class Driver implements DriverInterface
{
    /** @var DriverInterface */
    private $driver;

    /** @var ContextProvider */
    private $contextProvider;

    public function __construct(DriverInterface $driver, ContextProvider $contextProvider)
    {
        $this->driver          = $driver;
        $this->contextProvider = $contextProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(array $params)
    {
        return new Connection(
            $this->driver->connect($params),
            $this->contextProvider
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getDatabasePlatform()
    {
        return $this->driver->getDatabasePlatform();
    }

    /**
     * {@inheritDoc}
     */
    public function getSchemaManager(DBALConnection $conn, AbstractPlatform $platform)
    {
        return $this->driver->getSchemaManager($conn, $platform);
    }

    public function getExceptionConverter(): ExceptionConverter
    {
        return $this->driver->getExceptionConverter();
    }
}
