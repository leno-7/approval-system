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
    Schema::create('support_service_approvals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_request_id')->constrained()->cascadeOnDelete();
        $table->boolean('approved_by_support_exec')->default(false);
        $table->date('approved_by_support_exec_at')->nullable();
        $table->text('support_exec_notes')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_service_approvals');
    }
};
