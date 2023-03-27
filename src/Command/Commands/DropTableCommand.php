<?php
namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class DropTableCommand extends Command implements CommandInterface
{

    private $database, $table;

    protected $pattern = "%s `%s`.`%s`";

    public function __construct(string $database, string $table)
    {
        $this->database = $database;
        $this->table = $table;
    }

    public function getCommand() :self
    {
        return $this
        ->setName(EnumsCommand::Drop)
        ->setPattern($this->pattern)
        ->setIncludes([
            'database' => $this->database,
            'table' => $this->table,
        ]);
    }
}
