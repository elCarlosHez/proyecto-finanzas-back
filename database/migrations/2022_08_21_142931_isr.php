<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ISR', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lower_limit');
            $table->bigInteger('higher_limit')->nullable();
            $table->bigInteger('fixed_fee');
            $table->float('percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ISR');
    }
};
