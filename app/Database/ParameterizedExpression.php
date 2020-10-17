<?php

namespace App\Database;

use Illuminate\Database\Query\Expression;

class ParameterizedExpression extends Expression
{
    /** @var array */
    protected $bindings;

    /**
     * @param mixed $value The expression.
     * @param array $bindings Bindings associated with this expression.
     */
    public function __construct($value, array $bindings)
    {
        parent::__construct($value);
        $this->bindings = $bindings;
    }

    /**
     * Get the bindings associated with this expression.
     *
     * @return array
     */
    public function getBindings()
    {
        return $this->bindings;
    }
}
