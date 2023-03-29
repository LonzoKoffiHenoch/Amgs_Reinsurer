<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up():void
    {
        Schema::create('slips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->decimal('prime_total', 50, 2);
            $table->timestamps();
        });
    }


    public function down():void
    {
        Schema::dropIfExists('slips');
    }
};
