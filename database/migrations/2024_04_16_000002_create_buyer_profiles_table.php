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
        Schema::create("buyer_profiles", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->unique()->constrained("users")->onDelete("cascade");
            $table->string("company_name")->nullable();
            $table->string("buyer_type"); // Remplacé de enum
            $table->integer("total_orders")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("buyer_profiles");
    }
};
