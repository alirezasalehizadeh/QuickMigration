<?php

namespace Alirezasalehizadeh\QuickMigration\Enums;

enum Command: string
{
    case Create = "CREATE TABLE";
    case Drop = "DROP TABLE";
    case DropTableIfExists = "DROP TABLE IF EXISTS";
    case AlterTable = "ALTER TABLE";
    case CreateIndex = "CREATE INDEX";
    case DropIndex = "DROP INDEX";
}
