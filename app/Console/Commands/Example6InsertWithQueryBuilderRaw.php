<?php

namespace App\Console\Commands;

use App\Database\ParameterizedExpression;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Example6InsertWithQueryBuilderRaw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:6';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a musician record using the query builder.';

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
            'instruments' => new ParameterizedExpression('ARRAY(SELECT * FROM json_array_elements_text(?))::musical_instrument[]', [json_encode(['trumpet'])]),
        ]);
        $this->info('Inserted new musician.');
        return 0;
    }
}
