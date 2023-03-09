<?php
namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\CommandGenerator;

class CreateTableCommand extends CommandGenerator
{

    private $database, $table, $sqlCommands;

    protected $pattern = "CREATE TABLE `%s`.%s (%s)";

    public function __construct(string $database, string $table, array $sqlCommands)
    {
        $this->database = $database;
        $this->table = $table;
        $this->sqlCommands = $sqlCommands;
    }

    public function generate(): string
    {
        $sqlString = implode(" ,", $this->sqlCommands);
        return sprintf($this->pattern, $this->database, $this->table, $sqlString);
    }
}
