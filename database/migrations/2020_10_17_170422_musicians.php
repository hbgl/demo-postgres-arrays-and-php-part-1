<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

class Musicians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Grammar::macro('typeRaw', function (Fluent $column) {
            return $column->get('raw_type');
        });
        Blueprint::macro('addColumnRaw', function ($rawType, $name) {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            return $this->addColumn('raw', $name, ['raw_type' => $rawType]);
        });

        DB::unprepared("CREATE TYPE musical_instrument AS ENUM ('guitar', 'piano', 'bass', 'trumpet', 'drums');");

        Schema::create('musicians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->addColumnRaw('musical_instrument[]', 'instruments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('musicians');
        DB::unprepared("DROP TYPE IF EXISTS musical_instrument;");
    }
}
