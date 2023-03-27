<?php

namespace Alirezasalehizadeh\QuickMigration\Command;

use Alirezasalehizadeh\QuickMigration\Command\Command;

interface CommandInterface
{
    public function getCommand(): Command;
}
