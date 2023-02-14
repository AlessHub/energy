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
        Schema::create('consumptions', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_User');
            $table->foreign('id_User')->references('id')->on('users');
            $table->string('date');
            $table->decimal('electricMoney', 8, 2);
            $table->decimal('electricEnergy', 8, 2);
            $table->decimal('waterMoney', 8, 2);
            $table->decimal('waterEnergy', 8, 2);
            
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
        Schema::dropIfExists('consumptions');
    }
};