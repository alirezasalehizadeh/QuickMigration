<?php

namespace Alirezasalehizadeh\QuickMigration\Enums;

enum Command: string
{
    case Create = "CREATE TABLE";
    case Drop = "DROP TABLE";
    case DropTableIfExists = "DROP TABLE IF EXISTS";
}
