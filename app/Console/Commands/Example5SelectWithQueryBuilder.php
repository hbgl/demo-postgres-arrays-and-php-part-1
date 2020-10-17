<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Example5SelectWithQueryBuilder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select from musicians table using the query builder.';

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
        $musicians = DB::table('musicians')->select([
            'id',
            'name',
            DB::raw('array_to_json(instruments) as instruments'),
        ])->get()->all();
        var_dump($musicians);
        return 0;
    }
}
