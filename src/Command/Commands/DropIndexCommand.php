<?php
namespace Alirezasalehizadeh\QuickMigration\Command\Commands;

use Alirezasalehizadeh\QuickMigration\Command\Command;
use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;
use Alirezasalehizadeh\QuickMigration\Enums\Command as EnumsCommand;

class DropIndexCommand extends Command implements CommandInterface
{

    private $name, $table;

    protected $pattern = "%s %s DROP INDEX %s";

    public function __construct(string $name, string $table)
    {
        $this->name = $name;
        $this->table = $table;
    }

    public function getCommand() : self
    {
        return $this
        ->setName(EnumsCommand::AlterTable)
        ->setPattern($this->pattern)
        ->setIncludes([
            'name' => $this->name,
            'table' => $this->table,
        ]);
    }
}
