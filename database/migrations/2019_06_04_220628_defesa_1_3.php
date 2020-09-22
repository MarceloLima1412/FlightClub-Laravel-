<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Defesa13 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aeronaves', function (Blueprint $table) {
            $table->enum('tipo_certificacao', ['C', 'X', 'UL'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aeronaves', function (Blueprint $table) {
            $table->dropColumn(['tipo_certificacao']);
        });
    }
}
