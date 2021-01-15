<?php

declare(strict_types=1);

namespace Doctrine\SQLCommenter;

use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Doctrine\DBAL\Driver\Result as DriverResult;
use Doctrine\DBAL\Driver\Statement as DriverStatement;
use Doctrine\DBAL\ParameterType;

final class Connection implements ConnectionInterface
{
    /** @var ConnectionInterface */
    private $connection;

    /** @var Commenter */
    private $commenter;

    public function __construct(ConnectionInterface $connection, ContextProvider $contextProvider)
    {
        $this->connection = $connection;
        $this->commenter  = new Commenter($contextProvider);
    }

    public function prepare(string $sql): DriverStatement
    {
        return $this->connection->prepare(
            $this->commenter->augment($sql)
        );
    }

    public function query(string $sql): DriverResult
    {
        return $this->connection->query(
            $this->commenter->augment($sql)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function quote($value, $type = ParameterType::STRING)
    {
        return $this->connection->quote($value, $type);
    }

    public function exec(string $sql): int
    {
        return $this->connection->exec(
            $this->commenter->augment($sql)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function lastInsertId($name = null)
    {
        return $this->connection->lastInsertId($name);
    }

    /**
     * {@inheritDoc}
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * {@inheritDoc}
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * {@inheritDoc}
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }
}
