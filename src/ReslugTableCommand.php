<?php

namespace AlexeyMezenin\LaravelRussianSlugs;

use Illuminate\Console\Command;

/**
 * Class ReslugTableCommand
 * @package AlexeyMezenin\LaravelRussianSlugs\Commands
 */
class ReslugTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slug:reslug {table} {column}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating or recreating slugs for a specified table';

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

        try {
            $allRows = \DB::table($table)->select($column)->get();

            foreach ($allRows as $row) {
                \DB::table($table)->where($column, $row->$column)
                     ->update([config('seoslug.slugColumnName') => \Slug::build($row->$column)]);
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Table '.$table. 'has been reslugged successfully');
    }
}
