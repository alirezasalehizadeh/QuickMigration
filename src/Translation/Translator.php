<?php
namespace Alirezasalehizadeh\QuickMigration\Translation;

use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Translation\Translators\MySqlTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\Translators\PostgreSqlTranslator;

class Translator implements TranslatorInterface
{
    protected $pattern;

    public $availableTranslators = [
        "MySql" => MySqlTranslator::class,
        "PostgreSql" => PostgreSqlTranslator::class,
    ];

    public function setColumn(Column $column)
    {}

    public function make()
    {}

    public function matchName()
    {}

    public function matchType()
    {}

    public function matchNullable()
    {}

    public function matchAutoIncrement()
    {}

    public function matchDefault()
    {}

    public function matchAttribute()
    {}

}
