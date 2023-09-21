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
use Alirezasalehizadeh\QuickMigration\Structure\Column;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\AddColumnCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\CreateIndexCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\CreateTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropColumnCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropIfExistsTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropIndexCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\DropTableCommandTranslator;
use Alirezasalehizadeh\QuickMigration\Translation\CommandTranslator\Translators\ModifyColumnCommandTranslator;
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

        $sql = (new CreateTableCommandTranslator($command))->make();

        $this->assertSame("CREATE TABLE `foo`.`bar` (`id` INT NOT NULL)", $sql);
    }

    /** @test */
    public function canMakeDropTableCommandTest()
    {
        $command = (new DropTableCommand($this->database, $this->table))->getCommand();

        $sql = (new DropTableCommandTranslator($command))->make();

        $this->assertSame("DROP TABLE `foo`.`bar`", $sql);
    }

    /** @test */
    public function canMakeDropIfExistsTableCommandTest()
    {
        $command = (new DropIfExistsTableCommand($this->database, $this->table))->getCommand();

        $sql = (new DropIfExistsTableCommandTranslator($command))->make();

        $this->assertSame("DROP TABLE IF EXISTS `foo`.`bar`", $sql);
    }

    /** @test */
    public function canMakeCreateIndexCommandTest()
    {
        $command = (new CreateIndexCommand('foo_baz_index', $this->table, ['foo', 'baz']))->getCommand();

        $sql = (new CreateIndexCommandTranslator($command))->make();

        $this->assertSame("CREATE INDEX foo_baz_index ON bar(foo,baz)", $sql);
    }

    /** @test */
    public function canMakeDropIndexCommandTest()
    {
        $command = (new DropIndexCommand('foo_baz_index', $this->table))->getCommand();

        $sql = (new DropIndexCommandTranslator($command))->make();

        $this->assertSame("ALTER TABLE bar DROP INDEX foo_baz_index", $sql);
    }

    /** @test */
    public function canMakeDropColumnCommandTest()
    {
        $command = (new DropColumnCommand($this->table, 'baz'))->getCommand();

        $sql = (new DropColumnCommandTranslator($command))->make();

        $this->assertSame("ALTER TABLE `bar` DROP COLUMN baz", $sql);
    }

    /** @test */
    public function canMakeAddColumnCommandTest()
    {
        $column = new Column('baz', Type::Varchar);

        $command = (new AddColumnCommand($this->table, $column))->getCommand();

        $sql = (new AddColumnCommandTranslator($command))->make();

        $this->assertSame("ALTER TABLE `bar` ADD baz VARCHAR", $sql);
    }

    /** @test */
    public function canMakeModifyColumnCommandTest()
    {
        $column = new Column('baz', Type::Text);

        $command = (new ModifyColumnCommand($this->table, $column))->getCommand();

        $sql = (new ModifyColumnCommandTranslator($command))->make();

        $this->assertSame("ALTER TABLE `bar` MODIFY COLUMN baz TEXT", $sql);
    }
}
