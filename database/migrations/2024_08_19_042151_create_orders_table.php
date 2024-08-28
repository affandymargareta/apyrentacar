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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->text('wilayah');
            $table->string('fitur')->nullable();
            $table->text('product_id');
            $table->text('price');
            $table->text('addon_price')->nullable();
            $table->text('addon_hari')->nullable();
            $table->text('biaya_aplikasi')->nullable();
            $table->text('jemput_id')->nullable();
            $table->text('lokasi_jemput')->nullable();
            $table->text('lokasi_jemput_lengkap')->nullable();
            $table->text('kembali_id')->nullable();
            $table->text('lokasi_kembali')->nullable();
            $table->text('lokasi_kembali_lengkap')->nullable();
            $table->text('mulai')->nullable();
            $table->text('akhir')->nullable();
            $table->text('durasi')->nullable();
            $table->text('jam_mulai')->nullable();
            $table->text('jam_akhir')->nullable();
            $table->text('supir_telpon')->nullable();
            $table->text('supir_name')->nullable();
            $table->text('plat_nomer')->nullable();
            $table->text('customer_name')->nullable();
            $table->text('customer_telpon')->nullable();
            $table->text('customer_email')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->datetime('order_date');
            $table->datetime('payment_due');
            $table->string('payment_status');
            $table->string('payment_token')->nullable();
            $table->string('payment_url')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
