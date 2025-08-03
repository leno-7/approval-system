<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('financial_affairs', function (Blueprint $table) {
            $table->id();

            // الربط مع طلب المشروع
            $table->foreignId('project_request_id')->constrained()->cascadeOnDelete();

            // بيانات الربط المالي
            $table->string('has_financial_approval'); // نعم / لا
            $table->string('item_name');
            $table->string('item_number');
            $table->date('attachment_date')->nullable(); // auto تاريخ الارتباط
            $table->string('attachment_number')->nullable();
            $table->decimal('attachment_amount', 12, 2); // مبلغ الارتباط

            // اعتماد الموظف المختص للمالية
            $table->boolean('approved_by_specialist')->default(false);
            $table->timestamp('approved_by_specialist_at')->nullable();
            $table->text('specialist_notes')->nullable();

            // اعتماد مدير المالية
            $table->boolean('approved_by_financial')->default(false);
            $table->timestamp('approved_by_financial_at')->nullable();
            $table->text('financial_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_affairs');
    }
};
