<?php
namespace Alirezasalehizadeh\QuickMigration\Translation;

use Alirezasalehizadeh\QuickMigration\Structure\Column;

interface TranslatorInterface
{
    public function setColumn(Column $column);

    public function make();

    public function matchName();

    public function matchType();

    public function matchNullable();

    public function matchAutoIncrement();

    public function matchDefault();

    public function matchAttribute();
}
