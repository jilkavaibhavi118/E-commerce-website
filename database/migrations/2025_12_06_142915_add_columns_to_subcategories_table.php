<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {

            if (!Schema::hasColumn('subcategories', 'category_id')) {
                $table->foreignId('category_id')
                      ->constrained('categories')
                      ->onDelete('cascade')
                      ->after('id');
            }

            if (!Schema::hasColumn('subcategories', 'name')) {
                $table->string('name')->unique()->after('category_id');
            }

            if (!Schema::hasColumn('subcategories', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }

            if (!Schema::hasColumn('subcategories', 'status')) {
                $table->boolean('status')->default(true)->after('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {

            if (Schema::hasColumn('subcategories', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }

            if (Schema::hasColumn('subcategories', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('subcategories', 'slug')) {
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('subcategories', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
