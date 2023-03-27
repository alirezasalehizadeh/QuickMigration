<?php
namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class CreateTableCommand extends Command implements CommandInterface
{

    private $database, $table, $sqlCommands;

    protected $pattern = "%s `%s`.`%s` (%s)";

    public function __construct(string $database, string $table, array $sqlCommands)
    {
        $this->database = $database;
        $this->table = $table;
        $this->sqlCommands = $sqlCommands;
    }

    public function getCommand() : self
    {
        return $this
        ->setName(EnumsCommand::Create)
        ->setPattern($this->pattern)
        ->setIncludes([
            'database' => $this->database,
            'table' => $this->table,
            'sqlCommands' => $this->sqlCommands,
        ]);
    }
}
