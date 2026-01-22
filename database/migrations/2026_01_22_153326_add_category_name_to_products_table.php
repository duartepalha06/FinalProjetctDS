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
        Schema::table('products', function (Blueprint $table) {
            $table->string('category_name')->nullable()->after('category_id');
        });

        // Populate existing products with their category names
        DB::statement('
            UPDATE products p
            JOIN categories c ON p.category_id = c.id
            SET p.category_name = c.name
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category_name');
        });
    }
};
