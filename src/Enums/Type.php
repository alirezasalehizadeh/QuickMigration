<?php

namespace Alirezasalehizadeh\QuickMigration\Enums;

enum Type: string
{
    case Int = "INT";
    case Varchar = "VARCHAR";
    case Text = "TEXT";
    case Timestamp = "TIMESTAMP";
    case Json = "JSON";
    case Enum = "ENUM";
}
