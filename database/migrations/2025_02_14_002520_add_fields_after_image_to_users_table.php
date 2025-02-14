<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('banner')->nullable()->after('image');
            $table->text('about')->nullable()->after('banner');
            $table->text('description')->nullable()->after('about');
            $table->text('address')->nullable()->after('description');
            $table->string('phone_number')->nullable()->after('address');
            $table->string('wa_number')->nullable()->after('phone_number');
            $table->string('embed_youtube')->nullable()->after('wa_number');
            $table->string('maps')->nullable()->after('embed_youtube');
            $table->string('color')->nullable()->after('maps');
            $table->enum('status', ['active', 'nonactive'])->default('active')->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'banner', 'about', 'description', 'address', 'phone_number', 
                'wa_number', 'shopee', 'embed_youtube', 'maps', 'color', 'status'
            ]);
        });
    }
};
