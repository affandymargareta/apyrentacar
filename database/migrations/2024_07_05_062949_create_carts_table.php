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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->text('product_id');
            $table->text('price');
            $table->text('biaya_aplikasi')->nullable();
            $table->text('addon_price')->nullable();
            $table->text('addon_hari')->nullable();
            $table->text('wilayah');
            $table->text('jemput_id');
            $table->text('lokasi_jemput');
            $table->text('kembali_id')->nullable();
            $table->text('lokasi_kembali')->nullable();
            $table->text('mulai');
            $table->text('durasi');
            $table->text('jam_mulai');
            $table->text('jam_akhir');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->text('customer_name')->nullable();
            $table->text('customer_telpon')->nullable();
            $table->text('customer_email')->nullable();
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
        Schema::dropIfExists('carts');
    }
};
