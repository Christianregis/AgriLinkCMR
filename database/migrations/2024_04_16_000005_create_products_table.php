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
        Schema::create("products", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("category_id")->constrained("categories")->onDelete("cascade");
            $table->foreignId("region_id")->constrained("regions")->onDelete("cascade");
            $table->string("title");
            $table->string("slug")->unique();
            $table->text("description")->nullable();
            $table->integer("quantity");
            $table->string("unit");
            $table->decimal("price", 10, 2);
            $table->integer("min_order_qty")->default(1);
            $table->boolean("price_negotiable")->default(false);
            $table->timestamp("harvest_date")->nullable();
            $table->timestamp("expires_at")->nullable();
            $table->string("status"); // Remplacé de enum
            $table->integer("views_count")->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("products");
    }
};
