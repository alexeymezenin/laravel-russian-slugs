<?php

namespace AlexeyMezenin\LaravelRussianSlugs;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\BaseCommand;
use AlexeyMezenin\LaravelRussianSlugs\SlugMigrationCreator;

/**
 * Class CreateSlugMigrationCommand
 * @package AlexeyMezenin\LaravelRussianSlugs\Commands
 */
class CreateSlugMigrationCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slug:migration {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates migration to add a slug column';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SlugMigrationCreator $creator)
    {
        parent::__construct();
        $this->creator = $creator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $slugColumn = config('seoslug.slugColumnName');
        $migrationName = 'add_'.$slugColumn.'_to_'.$table.'_table';

        // Creating a migration
        try {
            $path = $this->getMigrationPath();
            $this->creator->setColumn($slugColumn);
            $file = pathinfo($this->creator->create($migrationName, $path, $table), PATHINFO_FILENAME);
        } catch(Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Migration for table '.$table.' has been created successfully');
    }
}
