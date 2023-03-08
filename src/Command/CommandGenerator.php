<?php
namespace Alirezasalehizadeh\QuickMigration\Command;

use Alirezasalehizadeh\QuickMigration\Command\CommandInterface;

abstract class CommandGenerator implements CommandInterface
{
    protected $pattern;

    public function generate(): string
    {
        return '';
    }
}
