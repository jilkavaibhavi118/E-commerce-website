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
        Schema::table('subcategories', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->after('id')->onDelete('cascade');
            $table->string('name')->unique()->after('category_id');
            $table->string('slug')->unique()->after('name');
            $table->boolean('status')->default(true)->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //
      Schema::dropIfExists('subcategories');
    }
};
