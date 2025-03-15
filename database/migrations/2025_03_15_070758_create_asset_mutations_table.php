<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetMutationsTable extends Migration
{
    public function up()
    {
        Schema::create('asset_mutations', function (Blueprint $table) {
            $table->id();
            $table->date('mutation_date');
            $table->integer('user_id');
            $table->text('description');
            $table->integer('asset_id');
            $table->integer('previous_room');
            $table->integer('new_room');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_mutations');
    }
}
