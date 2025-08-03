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
        Schema::create('planning_governance_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_request_id')->constrained()->cascadeOnDelete();
    
            // اعتماد مدير الإدارة العامة للتخطيط
            $table->boolean('approved_by_planning_director')->default(false);
            $table->date('approved_by_planning_director_at')->nullable();
            $table->text('planning_director_notes')->nullable();
    
            // اعتماد مساعد الرئيس التنفيذي للتطوير المؤسسي
            $table->boolean('approved_by_ceo_assistant')->default(false);
            $table->date('approved_by_ceo_assistant_at')->nullable();
            $table->text('ceo_assistant_notes')->nullable();
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_governance_approvals');
    }
};
