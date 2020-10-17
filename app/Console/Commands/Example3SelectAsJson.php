<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Example3SelectAsJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select from musicians table with instruments formatted as JSON.';

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
        $musicians = DB::select('SELECT id, name, array_to_json(instruments) as instruments FROM musicians');
        foreach ($musicians as $musician) {
            $musician->instruments = json_decode($musician->instruments);
        }
        var_dump($musicians);
        return 0;
    }
}
