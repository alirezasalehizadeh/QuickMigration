<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Constraints\Constraint;

class Column
{
    use Constraint;

    public function __construct(private string $name, private Type|string $type, private mixed $value = null)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type instanceof Type
            ? $this->type->value
            : strtoupper($this->type);
    }

    public function getValue()
    {
        return $this->value;
    }
}
