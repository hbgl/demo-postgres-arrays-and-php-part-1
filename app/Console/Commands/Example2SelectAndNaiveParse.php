<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Example2SelectAndNaiveParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example:2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select from musician table and naivly parse the instruments.';

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
        function maybeParseArrayOutput(string $output) {
            if ($output === '{}') {
                return [];
            }
            return mb_split(',', mb_substr($output, 1, -1));
        }
        $instruments = maybeParseArrayOutput('{guitar,piano}');
        // ['guitar', 'piano']

        var_dump($instruments);
        return 0;
    }
}
