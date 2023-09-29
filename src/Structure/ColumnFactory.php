<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Constraints\Foreign;

class ColumnFactory
{
    public static function create(string $name, Type|string $type, mixed $value = null)
    {
        return new Column($name, $type, $value);
    }

    public static function foreign(string $name, Type|string $type, mixed $value = null)
    {
        return new Foreign($name, $type, $value);
    }
}
