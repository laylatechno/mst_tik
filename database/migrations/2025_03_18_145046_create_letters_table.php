<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLettersTable extends Migration
{
    public function up()
    {
       Schema::create('letters', function (Blueprint $table) {
            $table->id();  
            $table->string('letter_number')->unique();  
            $table->enum('category', ['incoming', 'outgoing']);  
            $table->string('type');   
            $table->date('date');  
            $table->string('sender')->nullable();  
            $table->string('recipient')->nullable();  
            $table->string('subject');   
            $table->text('content')->nullable(); 
            $table->string('attachment')->nullable(); 
            $table->enum('status', ['pending', 'processed', 'completed', 'draft', 'sent'])->default('pending'); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  
            $table->timestamps();  
        });
    }

    public function down()
    {
        Schema::dropIfExists('letters');
    }
}
