<?php

namespace App\Database;

class Expr {
    public static function array(array $items, ?string $elementType = null): ParameterizedExpression
    {
        $sql = 'ARRAY(SELECT * FROM json_array_elements_text(?))';
        if ($elementType !== null) {
            $sql .= "::{$elementType}[]";
        }
        return new ParameterizedExpression($sql, [json_encode($items)]);
    }
}
