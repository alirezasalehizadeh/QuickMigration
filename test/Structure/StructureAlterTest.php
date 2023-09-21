<?php

namespace Alirezasalehizadeh\QuickMigration\Test\Structure;

use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Structure\Foreign;
use PHPUnit\Framework\TestCase;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;
use Alirezasalehizadeh\QuickMigration\Structure\TableAlter;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\TableAlterTranslationManager;

class StructureAlterTest extends TestCase
{
    /** @test */
    public function canChangeTableTest()
    {
        $commands = Structure::change('test', function (TableAlter $alter) {
            $alter->addColumn(new Column('foo', Type::Varchar));
            $alter->addConstraint((new Foreign('foo', Type::Varchar))->reference('id')->on('bar')->cascadeOnDelete()->restrictOnUpdate());
            $alter->modifyColumn(new Column('foo', Type::Text));
            $alter->dropColumn('foo');
        });

        $sql = (new TableAlterTranslationManager($commands))->translate();

        $this->assertSame("ALTER TABLE `test` ADD `foo` VARCHAR(255) NOT NULL", $sql[0]);
        $this->assertSame("ALTER TABLE `test` ADD CONSTRAINT FOREIGN KEY (foo) REFERENCES `bar`(id) ON UPDATE RESTRICT ON DELETE CASCADE", $sql[1]);
        $this->assertSame("ALTER TABLE `test` MODIFY COLUMN `foo` TEXT NOT NULL", $sql[2]);
        $this->assertSame("ALTER TABLE `test` DROP COLUMN foo", $sql[3]);
    }
}
