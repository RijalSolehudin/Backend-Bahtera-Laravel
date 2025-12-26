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
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
        $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
        $table->foreignId('guest_id')->nullable()->constrained()->nullOnDelete();
        $table->enum('status', ['pending','attending','not_attending'])->default('pending');
        $table->integer('people_count')->default(1);
        $table->text('message')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_s_v_p_s');
    }
};
