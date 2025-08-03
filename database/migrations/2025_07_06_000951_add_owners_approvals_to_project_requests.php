<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('project_requests', function (Blueprint $table) {
            // مسؤولي الإدارة المالكة
            $table->text('owner_director_notes')->nullable();
            
            $table->boolean('approved_by_first_owner')->nullable();
            $table->timestamp('approved_by_first_owner_at')->nullable();
            $table->text('first_owner_notes')->nullable();

            $table->boolean('approved_by_second_owner')->nullable();
            $table->timestamp('approved_by_second_owner_at')->nullable();
            $table->text('second_owner_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('project_requests', function (Blueprint $table) {
            $table->dropColumn([
                'owner_director_notes',
                'approved_by_first_owner',
                'approved_by_first_owner_at',
                'first_owner_notes',
                'approved_by_second_owner',
                'approved_by_second_owner_at',
                'second_owner_notes',
            ]);
        });
    }
};
