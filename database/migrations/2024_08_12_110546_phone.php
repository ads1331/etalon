<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('number');
            $table->string('type'); // Например, 'home', 'work', 'mobile'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phones');
    }
};
