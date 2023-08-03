<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Closure;
use Alirezasalehizadeh\QuickMigration\Structure\StructureBuilder;

class Structure
{
    public static function create(string $table, Closure $builder): array
    {
        $structure = new StructureBuilder($table);
        $builder($structure);
        return $structure->done();
    }
}
