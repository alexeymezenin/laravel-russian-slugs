<?php

namespace AlexeyMezenin\LaravelRussianSlugs;

use Illuminate\Database\Migrations\MigrationCreator;

/**
 * Class SlugMigrationCreator
 * @package AlexeyMezenin\LaravelRussianSlugs
 */
class SlugMigrationCreator extends MigrationCreator
{
    /**
     * Get the migration stub file.
     *
     * @param  string $table
     * @param  bool $create
     * @return string
     */
    protected function getStub($table, $create)
    {
        return $this->files->get($this->getStubPath().'/migration.stub');
    }

    /**
     * Populate the place-holders in the migration stub.
     *
     * @param  string $name
     * @param  string $stub
     * @param  string $table
     * @return string
     */
    protected function populateStub($name, $stub, $table)
    {
        $stub = parent::populateStub($name, $stub, $table);
        return str_replace('DummyColumn', $this->column, $stub);
    }

    /**
     * @param string $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    public function getStubPath()
    {
        return __DIR__ . '/../stubs';
    }
}
