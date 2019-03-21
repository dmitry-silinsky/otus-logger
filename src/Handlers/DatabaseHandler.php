<?php

namespace Otus\Logger\Handlers;

use Otus\Logger\Handler;
use PDO;

/**
 * Class DatabaseHandler
 *
 * CREATE TABLE log (
 *      id integer PRIMARY KEY,
 *      date date,
 *      level varchar(16),
 *      message text,
 *      context text
 * );
 */
class DatabaseHandler extends Handler
{
    /**
     * @var string Data Source Name
     * @see http://php.net/manual/en/pdo.construct.php
     */
    public $dsn;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $table;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = new PDO($this->dsn, $this->username, $this->password);
    }

    /**
     * @inheritdoc
     */
    public function log($level, $message, array $context = array()): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO ' . $this->table . ' (date, level, message, context) ' .
            'VALUES (:date, :level, :message, :context)'
        );
        $stmt->bindParam(':date', $this->getDate());
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':context', $this->contextStringify($context));
        $stmt->execute();
    }
}
