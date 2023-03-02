<?php
namespace Alirezasalehizadeh\QuickMigration\Translation;

abstract class Translator
{
    protected $availableTranslators = "MySql";
    
    protected $pattern;

    protected function make(){}

    protected function matchName(){}

    protected function matchType(){}

    protected function matchNullable(){}

    protected function matchAutoIncrement(){}

    protected function matchDefault(){}

    protected function matchAttribute(){}

}
