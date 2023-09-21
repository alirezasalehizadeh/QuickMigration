<?php

namespace Alirezasalehizadeh\QuickMigration\Structure;

use Closure;
use Alirezasalehizadeh\QuickMigration\Structure\StructureBuilder;

class Structure
{
    /**
     * Create table structure
     * 
     * @param string $table
     * @param Closure $builder
     * 
     * @return array
     */
    public static function create(string $table, Closure $builder): array
    {
        $structure = new StructureBuilder($table);
        $builder($structure);
        return $structure->done();
    }

    /**
     * Change table structure
     * 
     * @param string $table
     * @param Closure $alter
     * 
     * @return array
     */
    public static function change(string $table, Closure $alter): array
    {
        $tableAlter = new TableAlter($table);
        $alter($tableAlter);
        return $tableAlter->done();
    }
}
