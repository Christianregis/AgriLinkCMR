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
        Schema::create("orders", function (Blueprint $table) {
            $table->id();
            $table->string("order_number")->unique();
            $table->foreignId("buyer_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("farmer_id")->constrained("users")->onDelete("cascade");
            $table->string("status"); // Remplacé de enum
            $table->string("payment_method")->nullable();
            $table->text("delivery_address");
            $table->decimal("total_amount", 10, 2);
            $table->text("notes")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders");
    }
};
