<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('blog_category_id');
            $table->string('title');
            $table->string('slug');
            $table->date('posting_date');
            $table->string('author');
            $table->string('resume');
            $table->text('description');
            $table->string('reference');
            $table->string('image');
            $table->string('status');
            $table->integer('position');
            $table->integer('views');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
