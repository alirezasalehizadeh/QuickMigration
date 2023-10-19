<?php

namespace Alirezasalehizadeh\QuickMigration\Test\Command\CommandTranslator;

use Alirezasalehizadeh\QuickMigration\Command\Commands\AddColumnCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateIndexCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\CreateTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropColumnCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIfExistsTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropIndexCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\DropTableCommand;
use Alirezasalehizadeh\QuickMigration\Command\Commands\ModifyColumnCommand;
use Alirezasalehizadeh\QuickMigration\Enums\Type;
use Alirezasalehizadeh\QuickMigration\Structure\ColumnFactory;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\CommandTranslator;
use PHPUnit\Framework\TestCase;

class CommandTranslatorTest extends TestCase
{

    private string $database = 'foo';
    private string $table = 'bar';

    /** @test */
    public function canMakeCreateTableCommandTest()
    {
        $command = (new CreateTableCommand($this->database, $this->table, [
            '`id` INT NOT NULL'
        ]))->getCommand();

        $sql = (new CommandTranslator($command))->createTableCommandTranslator();

        $this->assertSame("CREATE TABLE `foo`.`bar` (`id` INT NOT NULL)", $sql);
    }

    /** @test */
    public function canMakeDropTableCommandTest()
    {
        $command = (new DropTableCommand($this->database, $this->table))->getCommand();

        $sql = (new CommandTranslator($command))->dropTableCommandTranslator();

        $this->assertSame("DROP TABLE `foo`.`bar`", $sql);
    }

    /** @test */
    public function canMakeDropIfExistsTableCommandTest()
    {
        $command = (new DropIfExistsTableCommand($this->database, $this->table))->getCommand();

        $sql = (new CommandTranslator($command))->dropIfExistsTableCommandTranslator();

        $this->assertSame("DROP TABLE IF EXISTS `foo`.`bar`", $sql);
    }

    /** @test */
    public function canMakeCreateIndexCommandTest()
    {
        $command = (new CreateIndexCommand('ban_baz_index', $this->database, $this->table, ['ban', 'baz']))->getCommand();

        $sql = (new CommandTranslator($command))->createIndexCommandTranslator();

        $this->assertSame("CREATE INDEX ban_baz_index ON foo.bar(ban,baz)", $sql);
    }

    /** @test */
    public function canMakeDropIndexCommandTest()
    {
        $command = (new DropIndexCommand('ban_baz_index', $this->database, $this->table))->getCommand();

        $sql = (new CommandTranslator($command))->dropIndexCommandTranslator();

        $this->assertSame("ALTER TABLE foo.bar DROP INDEX ban_baz_index", $sql);
    }

    /** @test */
    public function canMakeDropColumnCommandTest()
    {
        $command = (new DropColumnCommand($this->table, 'baz'))->getCommand();

        $sql = (new CommandTranslator($command))->dropColumnCommandTranslator();

        $this->assertSame("ALTER TABLE `bar` DROP COLUMN baz", $sql);
    }

    /** @test */
    public function canMakeAddColumnCommandTest()
    {
        $column = ColumnFactory::create('baz', Type::Varchar);

        $command = (new AddColumnCommand($this->table, $column))->getCommand();

        $sql = (new CommandTranslator($command))->addColumnCommandTranslator();

        $this->assertSame("ALTER TABLE `bar` ADD `baz` VARCHAR(255) NOT NULL", $sql);
    }

    /** @test */
    public function canMakeModifyColumnCommandTest()
    {
        $column = ColumnFactory::create('baz', Type::Text);

        $command = (new ModifyColumnCommand($this->table, $column))->getCommand();

        $sql = (new CommandTranslator($command))->modifyColumnCommandTranslator();

        $this->assertSame("ALTER TABLE `bar` MODIFY COLUMN `baz` TEXT NOT NULL", $sql);
    }
}
