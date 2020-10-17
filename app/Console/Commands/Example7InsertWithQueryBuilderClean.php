<?php

namespace App\Console\Commands;

use App\Database\Expr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Example7InsertWithQueryBuilderClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:7';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a musician record using the query builder with cleaned up code.';

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
        DB::table('musicians')->insert([
            'name' => 'Paula',
            'instruments' => Expr::array(['trumpet'], 'musical_instrument'),
        ]);
        $this->info('Inserted new musician.');
        return 0;
    }
}
