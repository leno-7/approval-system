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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
        
            // ربط المشروع
            $table->foreignId('project_request_id')->constrained()->onDelete('cascade');
        
            // مدخلات المستخدم
            $table->string('offering_duration')->nullable();                // مدة الطرح
            $table->string('offering_method')->nullable();                  // أسلوب الطرح
            $table->boolean('is_preplanned')->nullable();                   // يوجد تخطيط مسبق
            $table->json('submission_attachments')->nullable();             // ملفات العرض
        
            // ✅ اعتماد الموظف المختص للعقود والمشتريات
            $table->boolean('approved_by_procurement_specialist')->nullable();
            $table->date('approved_by_procurement_specialist_at')->nullable();
            $table->text('procurement_specialist_notes')->nullable();
        
            // ✅ اعتماد مدير عام العقود والمشتريات
            $table->boolean('approved_by_procurement_manager')->nullable();
            $table->date('approved_by_procurement_manager_at')->nullable();
            $table->text('procurement_manager_notes')->nullable();
        
            $table->timestamps();
       
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
