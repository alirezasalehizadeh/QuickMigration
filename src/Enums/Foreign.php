<?php

namespace Alirezasalehizadeh\QuickMigration\Enums;

enum Foreign: string
{
    case Cascade = "CASCADE";
    case Restrict = "RESTRICT";
    case SetNull = "SET NULL";
    case NoAction = "NO ACTION";
}
