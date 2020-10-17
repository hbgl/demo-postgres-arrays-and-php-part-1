<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MusicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(<<<SQL
            INSERT INTO musicians ("name", instruments) VALUES
                ('Peter', '{guitar,piano}');
SQL
        );
    }
}
