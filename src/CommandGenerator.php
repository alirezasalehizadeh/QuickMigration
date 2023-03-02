<?php
namespace Alirezasalehizadeh\QuickMigration;

class CommandGenerator
{

    private $createPattern = "CREATE TABLE `%s`.%s (%s) ENGINE = %s";

    private $dropPattern = "DROP TABLE `%s`.`%s`";

    public function createTableCommand(string $database, string $table, array $sqlCommands, string $engine)
    {
        $sqlString = implode(" ,", $sqlCommands);
        return sprintf($this->createPattern, $database, $table, $sqlString, $engine);
    }

    public function dropTableCommand(string $database, string $table)
    {
        return sprintf($this->dropPattern, $database, $table);
    }
}
