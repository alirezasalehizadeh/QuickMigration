<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator;

class ColumnTranslateManager
{

    private $translator;

    public function __construct($translator = null)
    {
        $this->resolveTranslator($translator);
    }

    public function translate(array $columns): array
    {
        return array_map(fn ($column) => $this->translator->setColumn($column)->make(), $columns);
    }

    private function resolveTranslator($translator)
    {
        $columnTranslator = new ColumnTranslator;

        $this->translator = array_key_exists($translator, $columnTranslator->availableTranslators)
            ? new $columnTranslator->availableTranslators[$translator]
            : new $columnTranslator->availableTranslators["MySql"];
    }
}
