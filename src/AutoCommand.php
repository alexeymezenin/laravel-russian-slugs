<?php

namespace AlexeyMezenin\LaravelRussianSlugs;

use Illuminate\Console\Command;

/**
 * Class AutoCommand
 * @package AlexeyMezenin\LaravelRussianSlugs\Commands
 */
class AutoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slug:auto {table} {column}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates and executes migration and reslugs a table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $column = $this->argument('column');
        $slugColumn = config('seoslug.slugColumnName');

        if (\Schema::hasColumn($table, $slugColumn)) {
            $this->info('Slug column \''.$slugColumn.'\' does already exist');
        } else {
            try {
                $this->call('slug:migration', ['table' => $table]);
                $this->call('migrate');
            } catch(Exception $e) {
                $this->error('Something went wrong while trying to create migration and migrate');
            }
        }

        $this->call('slug:reslug', ['table' => $table, 'column' => $column]);
        $this->info('All jobs completed. Please run \'composer dump-autoload\' command to register new migration');
    }
}
