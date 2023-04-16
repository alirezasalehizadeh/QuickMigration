<?php

namespace Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator;

class ColumnTranslateManager
{

    private $translator;

    private $translatedColumns = [];

    public function __construct($translator = null)
    {
        $this->resolveTranslator($translator);
    }
    
    public function translate(array $columns): array
    {
        foreach ($columns as $column) {
            $this->translatedColumns[] = $this->translator->setColumn($column)->make();
        }
        return $this->translatedColumns;
    }
    
    private function resolveTranslator($translator)
    {
        $columnTranslator = new ColumnTranslator;
    
        $this->translator = in_array($translator, $columnTranslator->availableTranslators)
        ? new $columnTranslator->availableTranslators[$translator]
        : new $columnTranslator->availableTranslators["MySql"];
    }
}
