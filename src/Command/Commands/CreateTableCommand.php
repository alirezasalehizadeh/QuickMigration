<?php
namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\CommandGenerator;

class CreateTableCommand extends CommandGenerator
{

    private $database, $table, $sqlCommands, $engine;

    protected $pattern = "CREATE TABLE `%s`.%s (%s) ENGINE = %s";

    public function __construct(string $database, string $table, array $sqlCommands, string $engine)
    {
        $this->database = $database;
        $this->table = $table;
        $this->sqlCommands = $sqlCommands;
        $this->engine = $engine;
    }

    public function generate(): string
    {
        $sqlString = implode(" ,", $this->sqlCommands);
        return sprintf($this->pattern, $this->database, $this->table, $sqlString, $this->engine);
    }
}
