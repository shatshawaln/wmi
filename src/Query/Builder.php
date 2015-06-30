<?php

namespace Stevebauman\Wmi\Query;

use Stevebauman\Wmi\Query\Expressions\From;
use Stevebauman\Wmi\Query\Expressions\Where;
use Stevebauman\Wmi\Query\Expressions\Select;
use Stevebauman\Wmi\ConnectionInterface;

class Builder implements BuilderInterface
{
    /**
     * The select statements of the current query.
     *
     * @var Select
     */
    protected $select;

    /**
     * The from statement of the current query.
     *
     * @var From
     */
    protected $from;

    /**
     * The where statements of the current query.
     *
     * @var array
     */
    protected $wheres = [];

    /**
     * The current connection.
     *
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Adds columns to the select query statement.
     *
     * @param array|string $columns
     *
     * @return $this
     */
    public function select($columns)
    {
        $this->select = new Select($columns);

        return $this;
    }

    /**
     * Adds a where expression to the current query.
     *
     * @param string $column
     * @param string $operator
     * @param mixed  $value
     *
     * @return $this
     */
    public function where($column, $operator, $value)
    {
        $this->addWhere(new Where($column, $operator, $value));

        return $this;
    }

    /**
     * Adds an and where expression to the current query.
     *
     * @param string $column
     * @param string $operator
     * @param mixed  $value
     *
     * @return $this
     */
    public function andWhere($column, $operator, $value)
    {
        $this->addWhere(new Where($column, $operator, $value, 'AND'));

        return $this;
    }

    /**
     * Adds a or where statement to the current query.
     *
     * @param $column
     * @param $operator
     * @param mixed $value
     *
     * @return $this
     */
    public function orWhere($column, $operator, $value)
    {
        $this->addWhere(new Where($column, $operator, $value, 'OR'));

        return $this;
    }

    /**
     * Adds a from statement to the current query.
     *
     * @param string $namespace
     *
     * @return $this
     */
    public function from($namespace)
    {
        $this->from = new From($namespace);

        return $this;
    }

    /**
     * Adds a Where expression to the current query.
     *
     * @param Where $where
     *
     * @return $this
     */
    private function addWhere(Where $where)
    {
        $this->wheres[] = $where;

        return $this;
    }

}
