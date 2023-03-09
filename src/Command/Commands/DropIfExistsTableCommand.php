<?php
namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\CommandGenerator;

class DropIfExistsTableCommand extends CommandGenerator
{

    private $database, $table;

    protected $pattern = "DROP TABLE IF EXISTS `%s`.`%s`";

    public function __construct(string $database, string $table)
    {
        $this->database = $database;
        $this->table = $table;
    }

    public function generate(): string
    {
        return sprintf($this->pattern, $this->database, $this->table);
    }
}
