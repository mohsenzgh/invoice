<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_company')->nullabe();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 450;');
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
