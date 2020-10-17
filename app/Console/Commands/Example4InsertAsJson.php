<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Example4InsertAsJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:4';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a musician record with the instruments array formatted as JSON.';

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
     * @return int
     */
    public function handle()
    {
        DB::insert(<<<SQL
            INSERT INTO musicians (name, instruments) VALUES
                ('Mike', ARRAY(SELECT * FROM json_array_elements_text(?))::musical_instrument[]);
SQL
        , [
            json_encode(['drums', 'bass']),
        ]);
        $this->info('Inserted new musician.');
        return 0;
    }
}
