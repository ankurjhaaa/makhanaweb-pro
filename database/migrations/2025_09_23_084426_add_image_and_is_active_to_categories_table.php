<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('imageid')->nullable()->after('description');
            $table->string('imagelink')->nullable()->after('imageid');
            $table->boolean('is_active')->default(true)->after('imagelink');
            $table->boolean('is_show')->default(false)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['imageid', 'imagelink','is_active','is_show']);

        });
    }
};
