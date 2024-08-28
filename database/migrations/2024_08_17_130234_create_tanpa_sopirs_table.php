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
        Schema::create('tanpa_sopirs', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('jenis');
            $table->unsignedBigInteger('wilayah');
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->text('bagasi');
            $table->text('kursi');
            $table->text('stock');
            $table->text('price');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('tanpa_sopirs');
    }
};
