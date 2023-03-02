<?php

namespace Alirezasalehizadeh\QuickMigration\Enums;

enum Type: string
{
    case Int = "INT";
    case Tinyint = "TINYINT";
    case Bigint = "BIGINT";
    case Varchar = "VARCHAR";
    case Text = "TEXT";
    case Date = "DATE";
    case Timestamp = "TIMESTAMP";
    case Boolean = "BOOLEAN";
    case Json = "JSON";
    case Enum = "ENUM";
    
}
