<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator;

use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\Translators\MySqlTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\Translators\PostgreSqlTranslator;

class ColumnTranslator implements ColumnTranslatorInterface
{
    protected $pattern;

    public $availableTranslators = [
        "MySql" => MySqlTranslator::class,
        "PostgreSql" => PostgreSqlTranslator::class,
    ];

    public function setColumn(Column $column)
    {
    }

    public function make()
    {
    }

    public function matchName()
    {
    }

    public function matchType()
    {
    }

    public function matchNullable()
    {
    }

    public function matchAutoIncrement()
    {
    }

    public function matchDefault()
    {
    }

    public function matchAttribute()
    {
    }

    public function matchForeignKey()
    {
    }

    public function matchAfter()
    {
    }
}
