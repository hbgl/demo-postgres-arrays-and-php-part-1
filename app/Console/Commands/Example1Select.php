<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Example1Select extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select from musician table.';

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
        $musicians = DB::select('SELECT * FROM musicians');
        var_dump($musicians);
        return 0;
    }
}
