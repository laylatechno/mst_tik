<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->integer('asset_category_id');
            $table->string('code');
            $table->date('purchase_date');
            $table->integer('value');
            $table->string('condition');
            $table->string('location');
            $table->string('status');
            $table->integer('user_id');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
