<?php

namespace AlexeyMezenin\RussianSeoSlugs\Commands;

use Illuminate\Console\Command;
use AlexeyMezenin\RussianSeoSlugs\Slug;

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
    protected $description = 'Recreating slugs for a specified table';

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
                //$this->info(PHP_EOL.$column.': '.$row->$column.PHP_EOL.Slug::url($row->$column).PHP_EOL);

                \DB::table($table)->where($column, $row->$column)
                    ->update([config('seoslug.slugColumnName') => Slug::url($row->$column)]);
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Table '.$table. 'has been reslugged successfully');
    }
}
