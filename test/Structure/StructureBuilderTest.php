<?php

namespace Alirezasalehizadeh\QuickMigration\Test\Structure;

use PHPUnit\Framework\TestCase;
use Alirezasalehizadeh\QuickMigration\Structure\Structure;
use Alirezasalehizadeh\QuickMigration\Structure\StructureBuilder;
use Alirezasalehizadeh\QuickMigration\Translation\ColumnTranslator\ColumnTranslateManager;

class StructureBuilderTest extends TestCase
{

    /** @test */
    public function createNullableColumnTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->string('foo', 100)->nullable();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` VARCHAR(100) NULL", $sql);
    }

    /** @test */
    public function createColumnWithAutoIncrementTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->number('foo')->autoIncrement();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` INT NOT NULL AUTO_INCREMENT", $sql);
    }

    /** @test */
    public function createColumnWithDefaultValueTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->tinyInt('foo')->default(1);

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` TINYINT NOT NULL DEFAULT('1')", $sql);
    }

    /** @test */
    public function createColumnWithUnsignedAttributeTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->bigInt('foo')->unsigned();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` BIGINT UNSIGNED NOT NULL", $sql);
    }

    /** @test */
    public function createNotNullUniqueVarcharTypeColumnTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->string('foo', 100)->unique();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` VARCHAR(100) NOT NULL UNIQUE", $sql);
    }

    /** @test */
    public function createTimestampTypeColumnTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->timestamp('foo');

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` TIMESTAMP NOT NULL", $sql);
    }

    /** @test */
    public function createTimestampColumnsTest()
    {
        $structure = new StructureBuilder('test');

        $structure->timestamps();

        $columns = $structure->done()['columns'];

        [$createdAt, $updatedAt] = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`created_at` TIMESTAMP NULL", $createdAt);
        $this->assertSame("`updated_at` TIMESTAMP NULL", $updatedAt);
    }

    /** @test */
    public function createJsonTypeColumnTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->json('foo');

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` JSON NOT NULL", $sql);
    }

    /** @test */
    public function createEnumTypeColumnTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->enum('foo', ['BAR', 'BAZ']);

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` ENUM('BAR','BAZ') NOT NULL", $sql);
    }

    /** @test */
    public function createEnumTypeColumnWithDefaultValueTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->enum('foo', ['BAR', 'BAZ'])->default('BAR');

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` ENUM('BAR','BAZ') NOT NULL DEFAULT('BAR')", $sql);
    }

    /** @test */
    public function createPrimaryColumnTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->number('foo')->primary();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` INT NOT NULL PRIMARY KEY", $sql);
    }

    /** @test */
    public function createNullableColumnHaveNullDefaultValueTest()
    {
        $structure = new StructureBuilder('test');

        $structure->number('foo')->nullable()->default(1);
        $structure->number('bar')->default(2)->nullable();

        $columns = $structure->done()['columns'];

        [$foo, $bar] = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`foo` INT NULL", $foo);
        $this->assertSame("`bar` INT NULL", $bar);
    }

    /** @test */
    public function createNullableIntTypeColumnAndUniqueStringTypeColumnTest()
    {
        $structure = new StructureBuilder('test');

        $structure->number('foo')->nullable();
        $structure->string('bar', 100)->unique();

        $columns = $structure->done()['columns'];

        [$foo, $bar] = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`foo` INT NULL", $foo);
        $this->assertSame("`bar` VARCHAR(100) NOT NULL UNIQUE", $bar);
    }

    /** @test */
    public function createCustomColumnsTest()
    {
        $structure = new StructureBuilder('test');

        $structure->boolean('foo')->default(1);
        $structure->double('bar')->nullable();

        $columns = $structure->done()['columns'];

        [$foo, $bar] = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`foo` BOOLEAN NOT NULL DEFAULT('1')", $foo);
        $this->assertSame("`bar` DOUBLE NULL", $bar);
    }

    /** @test */
    public function createForeignColumnTest()
    {
        $structure = new StructureBuilder('test');

        $structure->foreign('foo')->reference('id')->on('bar')->cascadeOnDelete();

        $columns = $structure->done()['columns'];

        $sql = (new ColumnTranslateManager("MySql"))->translate($columns)[0];

        $this->assertSame("FOREIGN KEY (foo) REFERENCES `bar`(id) ON DELETE CASCADE", $sql);
    }

    /** @test */
    public function createForeignIdColumnTest()
    {
        $structure = new StructureBuilder('test');

        $structure->id();
        $structure->foreignBarId()->reference('id')->on('bar')->cascadeOnUpdate();
        
        $columns = $structure->done()['columns'];

        [$id, $foreignBarId] = (new ColumnTranslateManager("MySql"))->translate($columns);

        $this->assertSame("`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY", $id);
        $this->assertSame("FOREIGN KEY (bar_id) REFERENCES `bar`(id) ON UPDATE CASCADE", $foreignBarId);
    }

    /** @test */
    public function createRelationTest()
    {
        $userStructure = new StructureBuilder('users');
        $userStructure->number('id')->primary()->autoIncrement();
        $usersColumn = $userStructure->done()['columns'];

        $postStructure = new StructureBuilder('posts');
        $postStructure->number('user_id');
        $postStructure->foreign('user_id')->reference('id')->on('users')->cascadeOnDelete();
        $postsColumn = $postStructure->done()['columns'];

        $userId = (new ColumnTranslateManager("MySql"))->translate($usersColumn)[0];
        [$postUserId, $foreignUserId] = (new ColumnTranslateManager("MySql"))->translate($postsColumn);

        $this->assertSame("`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY", $userId);
        $this->assertSame("`user_id` INT NOT NULL", $postUserId);
        $this->assertSame("FOREIGN KEY (user_id) REFERENCES `users`(id) ON DELETE CASCADE", $foreignUserId);
    }

    /** @test */
    public function createIndexedColumnTest()
    {
        $structure = new StructureBuilder('test');

        $column = $structure->string('foo')->index()->unique();

        $sql = (new ColumnTranslateManager())->translate([$column])[0];

        $this->assertSame("`foo` VARCHAR(255) NOT NULL UNIQUE , INDEX(foo)", $sql);
    }

    /** @test */
    public function createColumnAfterSpecificColumnTest()
    {
        $structure = new StructureBuilder('test');

        $structure->string('foo')->nullable();
        $structure->string('bar');
        $structure->number('baz')->after('foo');

        $columns = $structure->done()['columns'];

        [$foo, $bar, $baz] = (new ColumnTranslateManager())->translate($columns);

        $this->assertSame("`foo` VARCHAR(255) NULL", $foo);
        $this->assertSame("`bar` VARCHAR(255) NOT NULL", $bar);
        $this->assertSame("`baz` INT NOT NULL AFTER foo", $baz);
    }

    /** @test */
    public function createStructureTest()
    {
        $structure = Structure::create('test', function (StructureBuilder $builder) {
            $builder->string('foo')->index()->unique();
        });

        $sql = (new ColumnTranslateManager())->translate($structure['columns'])[0];

        $this->assertSame("`foo` VARCHAR(255) NOT NULL UNIQUE , INDEX(foo)", $sql);
    }
}
